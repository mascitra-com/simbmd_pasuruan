<?php
if ( ! function_exists('monefy'))
{
	function monefy($text="", $is_decimal = TRUE)
	{
		if ($is_decimal) {
			return number_format($text,2,',','.');
		}
		return number_format($text);
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
	function datify($string, $format = 'd-m-Y')
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

if ( ! function_exists('unmonefy'))
{
	function unmonefy($string)
	{
		$string = str_replace('.', '', $string);
		return str_replace(',', '.', $string);
	}
}
?>