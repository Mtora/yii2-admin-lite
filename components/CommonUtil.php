<?php

namespace app\components;

use app\models\DeviceActive;
use app\models\Game;
use app\models\GamePay;
use app\models\PersonDaySta;
use app\models\PfList;
use app\models\Product;
use yii;

class CommonUtil {

    public static function getOnearr($arr, $str) {
        $res = array();
        foreach ($arr as $k => $v) {
            $res[] = $v[$str];
        }
        return $res;
    }

    //保留两个小数
    public static function sprintF2($del){
        return sprintf("%.2f", (int)$del / 100);
    }

    //获取本月充值总金额
    public static function getAmountMonth(){
        $user_id = Yii::$app->user->identity->id;
        $month_begin = date("Y-m-01", time());
        $month_end = date('Y-m-t', time());
        $total = PersonDaySta::find()->select('amount')
            ->andWhere(['user_id' => $user_id])
            ->andWhere(['>=', 'stat_time', $month_begin])
            ->andWhere(['<=', 'stat_time', $month_end])
            ->asArray()->all();
        $return = array_sum(CommonUtil::getOnearr($total, 'amount'));
        return sprintf("%.2f",$return/100);
    }

    //获取本月新增设备数
    public static function getDevicenumMonth(){
        $user_id = Yii::$app->user->identity->id;
        $month_begin = date("Y-m-01", time());
        $month_end = date('Y-m-t', time());
        $nums = PersonDaySta::find()->select('device_num')
            ->andWhere(['user_id' => $user_id])
            ->andWhere(['>=', 'stat_time', $month_begin])
            ->andWhere(['<=', 'stat_time', $month_end])
            ->asArray()->all();
        $return = array_sum(CommonUtil::getOnearr($nums, 'device_num'));
        return $return;
    }

    //获取本月新增账号数
    public static function getNewamountMonth(){
        $user_id = Yii::$app->user->identity->id;
        $month_begin = date("Y-m-01", time());
        $month_end = date('Y-m-t', time());
        $nums = PersonDaySta::find()->select('member_num')
            ->andWhere(['user_id' => $user_id])
            ->andWhere(['>=', 'stat_time', $month_begin])
            ->andWhere(['<=', 'stat_time', $month_end])
            ->asArray()->all();
        $return = array_sum(CommonUtil::getOnearr($nums, 'member_num'));
        return $return;
    }











    public static function productSelect($selected_val = '', $name = 'product_slt', $class = 'form-control select2', $id = '', $placeholder = '', $style = '')
    {
        $show_arr = [];
        $optionstr = '';
        $default_value = $name == 'product_slt' ? 'all' : '';
        $defaultstr = !empty($placeholder) ? $placeholder : '--　全部产品　--';
        $show_arr = self::getProSelect();
        $optionstr = '<option value=' . $default_value . '>' . $defaultstr . '</option>';
        foreach ($show_arr as $key => $val)
        {
            if ($key == $selected_val)
            {
                $optionstr .= "<option selected value=" . $key . ">" . $val['product_name'] . "</option>";
            }
            else
            {
                $optionstr .= "<option value=" . $key . ">" . $val['product_name'] . "</option>";
            }
        }
        echo <<<_HTML_
<select class="$class" name="$name" id="$id" placeholder="$placeholder" style="$style">
$optionstr
</select>
_HTML_;
    }
    /**
     * 输出渠道select的html模板
     * $selected_val 需要回填的数据(对应select的value)
     * $name,$id,$class,$style,$placeholder均指的是select的相关属性[多个class用空格隔开，例如col-sm-2 form-search]
     */
    public static function platformSelect($selected_val = '', $name = 'pfkey_slt', $class = 'form-control select2', $id = '', $placeholder = '', $style = '')
    {
        $show_arr = [];
        $optionstr = '';
        $defaultstr = !empty($placeholder) ? $placeholder : '--　全部渠道　--';
        $default_value = $name == 'pfkey_slt' ? 'all' : '';
        $show_arr = self::getPfSelect();
        $optionstr = '<option value=' . $default_value . '>' . $defaultstr . '</option>';
        foreach ($show_arr as $key => $val)
        {
            if ($key == $selected_val)
            {
                $optionstr .= "<option selected value=" . $key . ">" . $val . "</option>";
            }
            else
            {
                $optionstr .= "<option value=" . $key . ">" . $val . "</option>";
            }
        }
        echo <<<_HTML_
<select class="$class" name="$name" id="$id" placeholder="$placeholder" style="$style">
$optionstr
</select>
_HTML_;
    }
    /**
     * 获得需要加载的所有产品options,外面也有地方使用
     */
    public static function getProSelect()
    {
        $products = ArrayHelper::index(Product::find()->select(['product_id','product_name'])->where(['is_del' => 0])->orderBy('order DESC, product_id DESC')->asArray()->all(), 'product_id');
        return is_array($products) ? $products : [];
    }
    /**
     * 获得需要加载的所有渠道options,外面也有地方使用
     */
    public static function getPfSelect()
    {
        $pfs = PfList::getAllTypesForFront();
        return is_array($pfs) ? $pfs : [];
    }

    public static function getUserIP()
    {
        @$ip = $_SERVER['REMOTE_ADDR'];

        if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
            $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim($ips[0]);
        }
        return $ip;
    }
    /**
     * 数据中心默认的所有包
     **/
    public static function get_all_packages($pro_id)
    {
        if(empty($pro_id))
        {
            return [];
        }
        $order_by = ' convert(game_title USING gbk) COLLATE gbk_chinese_ci ASC, game_id DESC';
        $default_all_pkgs = Game::find()->select(['game_id', 'game_name', 'game_title', 'pf_key'])->where(['product_id' => $pro_id, 'is_del' => 0])->orderBy($order_by)->asArray()->all();
        return $default_all_pkgs;
    }
    /**
     * 日期转换成中国式的周一和周日,num=-1默认返回本周周一和周日的日期
     * 0表示上周 1表示上上周
     * -2表示下周 -3表示下下周
     * 以此类推
     */
    public static function GetStartAndEndDatesForWeek($num = -1)
    {
        $date = date('Y-m-d');  //当前日期
        $first = 1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
        $w = date('w', strtotime($date));  //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
        $now_start = date('Y-m-d', strtotime("$date -".($w ? $w - $first : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
        $now_end = date('Y-m-d', strtotime("$now_start + 6 days"));
        if ($num == -1)
        {
            return ['start' => $now_start, 'end' => $now_end];
        }
        $start_num = $end_num = $deal_num = 0;
        //下周、下下周以此类推
        if ($num < 0)
        {
            $deal_num = (abs($num) - 1) * 7;
            $next_start = date('Y-m-d', strtotime("$now_start + $deal_num days"));
            $next_end = date('Y-m-d', strtotime("$now_end + $deal_num days"));
            return ['start' => $next_start, 'end' => $next_end];
        }
        //上周、上上周，以此类推
        $start_num = 7 + $num * 7;
        $end_num = 1 + $num * 7;
        $start = date('Y-m-d', strtotime("$now_start - $start_num days"));  //上周开始日期 7=7 + 0*7, 上上周14=7 + 1*7
        $end = date('Y-m-d', strtotime("$now_start - $end_num days"));  //上周结束日期 1=1 + 0*7, 上上周8=1 + 1 * 7
        return ['start' => $start, 'end' => $end];
    }
    /**
     * 将一个字符串中间部分用其它字符替换，用于隐藏重要信息
     *
     * @param $str 原字符串
     * @param string $repl_char 替换后重复的字符
     * @param int $prefix_len 保持原样不被替换的前辍长度
     * @param int $shuffix_len 保持原样不被替换的后辍长度
     * @param bool $is_repeat 替换的字符是否需要根据被替换数重复出现
     * @param bool $force_hide 无论字符是否过短，都强制隐藏中间相应字符
     *
     * @return mixed
     */
    public static function hideCharByString($str, $repl_char = '*', $prefix_len = 0, $shuffix_len = 0, $is_repeat = true, $force_hide = true) {
        $strlen = strlen($str);
        //字符过短时，不强制隐藏字符的话直接返回全部明文
        if($strlen <= $prefix_len + $shuffix_len) {
            if(!$force_hide) return $str;
            $prefix_len = $shuffix_len = 0;
        }
        $start = $prefix_len;
        $length = $strlen - $prefix_len - $shuffix_len;
        return substr_replace($str, str_repeat($repl_char, $is_repeat ? $length : 1), $start, $length);
    }
}