<?php
include('simple_html_dom.php');

include('parsearticle.php');

$url="http://www.google.fr/url?q=http://www.lemonde.fr/economie/article/2017/05/04/plan-strategique-filiale-low-cost-air-france-attend-un-geste-des-pilotes_5122139_3234.html&sa=U&ved=0ahUKEwj3gunvmNnTAhXLDsAKHeYgB-8Q-AsIGCgCMAA&usg=AFQjCNERPJ9wIwS0LZw6X93viKctBa0nIA";

echo parsearticle($url);