<?php
if ( ! function_exists('monefy'))
{
	function monefy($text="")
	{
		return number_format($text,0,',','.');
	}
}

if ( ! function_exists('greetings'))
{
	function greetings()
	{
		$hour = date('H');
		if ($hour < 15)
		{
			return ($hour < 12) ? "Selamat Pagi" : "Selamat Siang";
		}
		else
		{
			return ($hour > 18) ? "Selamat Malam" : "Selamat Sore";
		}
	}
}

if ( ! function_exists('trim_empty_data'))
{
	function trim_empty_data($data)
	{
		foreach ($data as $index => $item)
        {
            if (empty($item) && $item !== '0')
            {
                unset($data[$index]);
            }
        }
        return $data;
	}
}

if ( ! function_exists('zerofy'))
{
	function zerofy($string, $digit = 2)
	{
		return str_pad($string, $digit, '0', STR_PAD_LEFT);
	}
}

if ( ! function_exists('datify'))
{
	function datify($string, $format)
	{
		return date($format, strtotime($string));
	}
}

if ( ! function_exists('unnullify'))
{
	function unnullify($string)
	{
		return ($string===null)?'':$string;
	}
}
?>