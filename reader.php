<?php		
include('simple_html_dom.php');


?>
<form method="post" action=reader.php>		

<input type="text" name=url>
<input type="submit" value="Valider">
</form>

<?php	
if(isset($_POST['url']))
{
	$url=$_POST['url'];
	$curl = curl_init($url);
	
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_USERAGENT, "CURL");

	$curl_scraped_page = curl_exec($curl);

	curl_close($curl);
	
	$html = new simple_html_dom();
	$html->load($curl_scraped_page);
	
	$text=$html->find("
	div[itemprop='articleBody'],
	div[itemprop='articlebody'],
	span[itemprop='articleBody'],
	.art-text,
	.contenuArt,
	.contenuart,
	.article-mask,
	.paragraph-read,
	.entry-content,
	.article-content,
	.content-text",
	0);
	
	$text=$text->plaintext;
	
	echo $text;
}
		