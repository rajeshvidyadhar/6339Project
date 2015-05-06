<!--
1. Analyzing Sentiment of Movie Review Data using Naive Bayes Neural Classifier. Lina L. Dhande, Dr. Prof. Girish K Patnaik. 4, SSBT’s College of Engineering and Technology, Bambhori, Jalgaon, Maharashtra, India : International Journal of Emerging Trends & Technology in Computer Science (IJETTCS), 2014, http://www.ijettcs.org/Volume3Issue4/IJETTCS-2014-08-25-138.pdf, Vol. 3. 2278-6856.
2. Yelp Dataset Challenge. Yelp.com. [Online] [Cited: 04 03, 2015.] http://www.yelp.com/dataset_challenge.
3. SemEval 2015. alt.qcri.org. [Online] [Cited: 04 03, 2015.] Aspect Based Sentiiment Analysis : Idea obtained from here. http://alt.qcri.org/semeval2015/task12/.
4. SemEval-2014 ABSA Restaurant Reviews - Train Data. Meta Share. [Online] [Cited: 04 03, 2015.] Training Data for Aspect Based Sentiment Analysis Obtained here. http://metashare.ilsp.gr:8080/repository/browse/semeval-2014-absa-restaurant-reviews-train-data/479d18c0625011e38685842b2b6a04d72cb57ba6c07743b9879d1a04e72185b8/.
5. Barber, Ian. Bayesian Opinion Mining. PHP/ir. [Online] 01 01, 2010. [Cited: 04 03, 2015.] Training Data set for regular Sentiment Analysis and the Naive Bayes concept of Sentiment Analysis learnt from here. http://www.phpir.com/bayesian-opinion-mining/
-->


<!DOCTYPE html>
<html>
<head>
	<title>Reviews</title>
</head>
<body>



<?php
echo "<h3>";
echo "Aspect based Sentiment Analysis";
echo "</h3>";


function polarity($wordcounts,$counts,$aspect){

$negativeprob=1;
$positiveprob=1;
$conflictprob=1;
$neutralprob=1;

foreach ($wordcounts as $x) {
	foreach ($x as $key => $value) {
		# code...
	
	$negativeprob=$negativeprob*(($value['negative']+1)/($counts['negative']+$counts['total']));
	$positiveprob=$positiveprob*(($value['positive']+1)/($counts['positive']+$counts['total']));
	$neutralprob=$neutralprob*(($value['neutral']+1)/($counts['neutral']+$counts['total']));
	$conflictprob=$conflictprob*(($value['conflict']+1)/($counts['conflict']+$counts['total']));
	//break;
	}
}

$negativeprob=$negativeprob*($counts['negative']/$counts['total']);
$positiveprob=$positiveprob*1.1*($counts['positive']/$counts['total']);
$neutralprob=$neutralprob*($counts['neutral']/$counts['total']);
$conflictprob=$conflictprob*($counts['conflict']/$counts['total']);

echo "<br>";
if(max($negativeprob,$positiveprob,$neutralprob,$conflictprob)==$negativeprob){
	echo ($aspect." has a Negative Review");
}
elseif (max($negativeprob,$positiveprob,$neutralprob,$conflictprob)==$positiveprob) {
	echo ($aspect." has a Positive Review");
}
elseif (max($negativeprob,$positiveprob,$neutralprob,$conflictprob)==$neutralprob) {
	echo $aspect." has a Neutral Review";
}
elseif (max($negativeprob,$positiveprob,$neutralprob,$conflictprob)==$conflictprob) {
	echo ($aspect." has a Conflict Review");
}

echo "<br>";

}

function totalcount($term){

$totalword=0;

$negativecount=0;
$positivecount=0;
$conflictcount=0;
$neutralcount=0;

foreach ($term as $y) {
	if($y[0]=='negative'){
			$negativecount=$negativecount+str_word_count($y[1]);
		}
		elseif ($y[0]=='positive') {
			$positivecount=$positivecount+str_word_count($y[1]);
		}
		elseif ($y[0]=='neutral') {
			$neutralcount=$neutralcount+str_word_count($y[1]);
		}
		elseif ($y[0]=='conflict') {
			$conflictcount=$conflictcount+str_word_count($y[1]);
		}

	$totalword=$totalword+str_word_count($y[1]);

	
}

echo"<pre>";
return (array('total'=>$totalword,'negative'=>$negativecount,'positive'=>$positivecount,'neutral'=>$neutralcount,'conflict'=>$conflictcount));
echo"</pre>";

}

function countword($word,$term){



$wordcount=array();



foreach ($word as $x) {
	$negativecount=0;
	$positivecount=0;
	$conflictcount=0;
	$neutralcount=0;
	foreach ($term as $y){ 
		if($y[0]=='negative'){

			$wordCounts = array_count_values(str_word_count($y[1],1));
			$sunCount = (isset($wordCounts[$x])) ? $wordCounts[$x] : 0;
			$negativecount=$negativecount+$sunCount;
		}
		elseif ($y[0]=='positive') {
			$wordCounts = array_count_values(str_word_count($y[1],1));
			$sunCount = (isset($wordCounts[$x])) ? $wordCounts[$x] : 0;
			$positivecount=$positivecount+$sunCount;
		}
		elseif ($y[0]=='neutral') {

			$wordCounts = array_count_values(str_word_count($y[1],1));
			$sunCount = (isset($wordCounts[$x])) ? $wordCounts[$x] : 0;
			$neutralcount=$neutralcount+$sunCount;
		}
		elseif ($y[0]=='conflict') {

			$wordCounts = array_count_values(str_word_count($y[1],1));
			$sunCount = (isset($wordCounts[$x])) ? $wordCounts[$x] : 0;
			$conflictcount=$conflictcount+$sunCount;
		}
	}
	array_push($wordcount,array($x=>array('negative'=>$negativecount,'positive'=>$positivecount,'neutral'=>$neutralcount,'conflict'=>$conflictcount)));


}
/*echo"<pre>";
print_r ($wordcount);
echo"</pre>";*/

return $wordcount;

}



function service($word){

$file = fopen("service.csv","r");
$service=array();
while(! feof($file))
  {
  	echo "<pre>";
  	array_push($service, fgetcsv($file));
    echo "</pre>";
  }
fclose($file);

$wordcounts=countword($word,$service);
$counts=totalcount($service);

/*echo "<pre>";
print_r($wordcounts);
echo "</pre>";

echo "<pre>";
print_r($counts);
echo "</pre>";*/
polarity($wordcounts,$counts,"Service");



}


function food($word){

$file = fopen("food.csv","r");
$service=array();
while(! feof($file))
  {
  	echo "<pre>";
  	array_push($service, fgetcsv($file));
    echo "</pre>";
  }
fclose($file);

$wordcounts=countword($word,$service);
$counts=totalcount($service);

/*echo "<pre>";
print_r($wordcounts);
echo "</pre>";

echo "<pre>";
print_r($counts);
echo "</pre>";*/
polarity($wordcounts,$counts,"Food");

}


function price($word){

$file = fopen("price.csv","r");
$service=array();
while(! feof($file))
  {
  	echo "<pre>";
  	array_push($service, fgetcsv($file));
    echo "</pre>";
  }
fclose($file);

$wordcounts=countword($word,$service);
$counts=totalcount($service);

/*echo "<pre>";
print_r($wordcounts);
echo "</pre>";

echo "<pre>";
print_r($counts);
echo "</pre>";*/
polarity($wordcounts,$counts,"Price");

}


function ambience($word){

$file = fopen("ambience.csv","r");
$service=array();
while(! feof($file))
  {
  	echo "<pre>";
  	array_push($service, fgetcsv($file));
    echo "</pre>";
  }
fclose($file);

$wordcounts=countword($word,$service);
$counts=totalcount($service);

/*echo "<pre>";
print_r($wordcounts);
echo "</pre>";

echo "<pre>";
print_r($counts);
echo "</pre>";*/
polarity($wordcounts,$counts,"Ambience");


}

//$string="I also ordered for delivery and the restaurant forgot half the order.";
//$string="Cheap, unpretentious, and, for this, one of my favorite breakfast joints in the country. Simply put I LOVE it here. The mixed grill, the sausage and egg on a biscuit, the home fries. This it the very definition of diner. Thank you Gab 'n' Eat!";
//$string="Good Luck getting a seat, that's all I have to say. The Gab and Eat is famous and infamous. Diner food is what's up and I like it. When I was a roofing mechanic, we'd meet there before work. Although I'm not sure I would recommend it if you're working were there's no bathrooms. hehe";
$string=urldecode($_POST['text2']);

echo "<p>";
echo $string;
echo "</p>";	

$word= preg_split("/[^a-zA-Z']/", strtolower($string));

$word=array_unique($word,SORT_REGULAR);

$stopwords=array('themselves', 'while', 'yours', 'them', 'most', 'or', 'will', 'down', 'himself', 'has', 'our', 'than', 'as', 'been', 'off', 'we', 'am', 'over', 'each', 'once', 'again', 'all', 'yourself', 'there', 'just', 'what', 'this', 'being', 'for', 'were', 'have', 'theirs', 'between', 'he', 'was', 'his', 'to', 'few', 'itself', 'herself', 'no', 's', 'a', 'any', 'doing', 'those', 'how', 'do', 'until', 'had', 'below', 'both', 'they', 'during', 'own', 'more', 'why', 'only', 't', 'about', 'of', 'such', 'at', 'does', 'against', 'before', 'him', 'too', 'into', 'should', 'her', 'where', 'other', 'when', 'which', 'it', 'under', 'because', 'from', 'ourselves', 'is', 'its', 'myself', 'an', 'my', 'after', 'here', 'in', 'your', 'with', 'further', 'can', 'she', 'whom', 'out', 'i', 'hers', 'yourselves', 'same', 'are', 'don', 'very', 'now', 'above', 'the', 'by', 'ours', 'through', 'if', 'you', 'these', 'having', 'did', 'but', 'me', 'that', 'who', 'nor', 'be', 'some', 'and', 'up', 'so', 'on', 'their', 'then'
);	


$word=array_diff($word, $stopwords);
$word=array_values($word);
$word=array_filter($word);

$servicekey=array("service","waiter","waitress","quick","quickly","fast","slow");
$pricekey=array("cost","value","expensive","price","worth","charge");
$ambiencekey=array("ambience","feel","atmosphere","vibes","lighting","smell");

if(count(array_intersect($servicekey, $word))> 0){
service($word);	
}
if(count(array_intersect($pricekey, $word))>0){
	price($word);
}
if(count(array_intersect($ambiencekey, $word))>0){
ambience($word);

}

food($word);


?>



</body>
</html>
