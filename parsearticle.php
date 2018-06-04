<?php


function parsearticle($url)
{
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);

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
	
	if(isset($text))
	{
		$text=$text->plaintext;
	}

	return $text;
}

