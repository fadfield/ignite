<?php
function backend_url(){
	$CI =& get_instance();
	return base_url().'backend/';	
}
function assets_url(){
	$CI =& get_instance();
	return base_url().'assets/';	
}
function slugify($text){
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  $text = preg_replace('~[^-\w]+~', '', $text);
  $text = trim($text, '-');
  $text = preg_replace('~-+~', '-', $text);
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}
function decimal_number_format($number, $decimal){
	if(is_decimal($number)){
		return number_format($number, $decimal);
	}else{
		return number_format($number);
	}
}
function is_decimal( $val ){
    return is_numeric( $val ) && floor( $val ) != $val;
}
function comma_separated($array){
	$combine = '';
	
	foreach($array as $item){
		$combine .= ucwords($item) . ', ';
	}
	
	return substr($combine, 0, -2);

}
function center_print($str){
	$CI =& get_instance();
	
	if($CI->settings->has('printer_max_character')){
		$printer_max_char = $CI->settings->get('printer_max_character');
	}else{
		$printer_max_char = 0;
	}
	
	$nbsp = "";
	if($printer_max_char > 0){
		$str_len = strlen($str);
		$diff = abs(trim($str_len) - $printer_max_char) / 2;
		for($i=1; $i<=$diff; $i++){
			$nbsp .= ' ';
		}
	}
	
	return $nbsp.$str;
}
function ucw($text){
	return ucwords(strtolower($text));	
}
function flattern_array($array, $key_name, $flats = array(), $indent = 0){
	
	if(empty($flats)) {
		$indent = 0;
	}else{
		$indent += 4;
	}
		
	foreach($array as $key=>$value){
		$childs = $value[$key_name];
		
        unset($value[$key_name]);
		$value['indent'] = $indent;
		$flats[] = $value; 		
		$flats = flattern_array($childs, $key_name, $flats, $indent);
	}
	
	return $flats;
}
function pretty_print($array){
	echo '<pre>';
	print_r($array);
	exit();	
}
function is_nbsp($num){
	$nbsp = '';
	for($i=0;$i<=$num;$i++){
		$nbsp .= '&nbsp;';
	}
	return $nbsp;
}
function no_img($filename, $default = 'no-image.png'){
	$picture = base_url().'img/'.$default;
	$path = 'uploads/'.$filename;
	
	if (file_exists($path) && is_file($path) ) {
		$picture = base_url().$path;
	}
	
	return $picture;
}


/*	 ---------------------
	 | Tanggal Indonesia |
	 ---------------------	
*/

if ( ! function_exists('bulan'))
{
	function bulan($bln)
	{
		switch ($bln)
		{
			case 1:
				return "Januari";
				break;
			case 2:
				return "Februari";
				break;
			case 3:
				return "Maret";
				break;
			case 4:
				return "April";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Juni";
				break;
			case 7:
				return "Juli";
				break;
			case 8:
				return "Agustus";
				break;
			case 9:
				return "September";
				break;
			case 10:
				return "Oktober";
				break;
			case 11:
				return "November";
				break;
			case 12:
				return "Desember";
				break;
		}
	}
}
if ( ! function_exists('nama_hari'))
{
	function nama_hari($tanggal)
	{
		$ubah = gmdate($tanggal, time()+60*60*8);
		$pecah = explode("-",$ubah);
		$tgl = $pecah[2];
		$bln = $pecah[1];
		$thn = $pecah[0];

		$nama = date("l", mktime(0,0,0,$bln,$tgl,$thn));
		$nama_hari = "";
		if($nama=="Sunday") {$nama_hari="Minggu";}
		else if($nama=="Monday") {$nama_hari="Senin";}
		else if($nama=="Tuesday") {$nama_hari="Selasa";}
		else if($nama=="Wednesday") {$nama_hari="Rabu";}
		else if($nama=="Thursday") {$nama_hari="Kamis";}
		else if($nama=="Friday") {$nama_hari="Jumat";}
		else if($nama=="Saturday") {$nama_hari="Sabtu";}
		return $nama_hari;
	}
}
if ( ! function_exists('tgl_indo'))
{
	function tgl_indo($tgl)
	{
		$ubah = gmdate($tgl, time()+60*60*8);
		$pecah = explode("-",$ubah);
		$tanggal = $pecah[2];
		$bulan = bulan($pecah[1]);
		$tahun = $pecah[0];
		return $tanggal.' '.$bulan.' '.$tahun;
	}
}
if ( ! function_exists('bulan_tahun'))
{
	function bulan_tahun($tgl)
	{
		$ubah = gmdate($tgl, time()+60*60*8);
		$pecah = explode("-",$ubah);
		$tanggal = $pecah[2];
		$bulan = bulan($pecah[1]);
		$tahun = $pecah[0];
		return $bulan.' '.$tahun;
	}
}
if ( ! function_exists('nama_bulan'))
{
	function nama_bulan($tgl)
	{
		$ubah = gmdate($tgl, time()+60*60*8);
		$pecah = explode("-",$ubah);
		$tanggal = $pecah[2];
		$bulan = bulan($pecah[1]);
		$tahun = $pecah[0];
		return $bulan;
	}
}
if ( ! function_exists('hitung_mundur'))
{
	function hitung_mundur($wkt)
	{
		$waktu=array(	365*24*60*60	=> "tahun",
						30*24*60*60		=> "bulan",
						7*24*60*60		=> "minggu",
						24*60*60		=> "hari",
						60*60			=> "jam",
						60				=> "menit",
						1				=> "detik");

		$hitung = strtotime(gmdate ("Y-m-d H:i:s", time () +60 * 60 * 8))-$wkt;
		$hasil = array();
		if($hitung<5)
		{
			$hasil = 'kurang dari 5 detik yang lalu';
		}
		else
		{
			$stop = 0;
			foreach($waktu as $periode => $satuan)
			{
				if($stop>=6 || ($stop>0 && $periode<60)) break;
				$bagi = floor($hitung/$periode);
				if($bagi > 0)
				{
					$hasil[] = $bagi.' '.$satuan;
					$hitung -= $bagi*$periode;
					$stop++;
				}
				else if($stop>0) $stop++;
			}
			$hasil=implode(' ',$hasil).' yang lalu';
		}
		return $hasil;
	}
}
