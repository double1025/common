<?php

namespace XWX\Common\Traits\Helpers;


use Carbon\Carbon;

trait TraitHelperCarbon
{
    /**
     * 周第一天
     *
     * @param null $date
     * @return Carbon
     */
    static function funcCarbonStartOfWeek($date = null)
    {
        $d = static::now();
        if ($date != null)
        {
            $d = $date;
        }

        return $d->startOfWeek();
    }

    /**
     * 周最后一天
     *
     * @param null $date
     * @return Carbon
     */
    static function funcCarbonEndOfWeek($date = null)
    {
        $d = static::now();
        if ($date != null)
        {
            $d = $date;
        }

        return $d->endOfWeek();
    }


    /**
     * 两个日期之间的天列表
     *
     * @param Carbon $date_begin
     * @param Carbon $date_end
     * @param null $format 字符串输出格式，例：Y-m-i
     * @return array
     */
    static function funcCarbonGetDates(Carbon $date_begin, Carbon $date_end, $format = null)
    {
        $dates = [];

        $date_index = $date_begin->copy();
        while ($date_index <= $date_end)
        {
            if ($format == null)
            {
                $dates[] = $date_index->toDateString();
            }
            else
            {
                $dates[] = $date_index->format($format);
            }

            $date_index->addDay();
        }

        return $dates;
    }


    /**
     * 两个日期之间的月份列表
     *
     * @param Carbon $date_begin
     * @param Carbon $date_end
     * @param null $format 字符串输出格式，例：Y-m
     * @return array
     */
    static function funcCarbonGetMonths(Carbon $date_begin, Carbon $date_end, $format = null)
    {
        $months = [];

        $date_index = $date_begin->copy();
        while ($date_index <= $date_end)
        {
            if ($format == null)
            {
                //返回每个1号，时间对象
                $months[] = Carbon::parse($date_index->format('Y-m-01'));
            }
            else
            {
                $months[] = $date_index->format($format);
            }

            $date_index->addMonthNoOverflow();
        }

        return $months;
    }
}