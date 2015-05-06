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
	<title>Sentiment Analysis</title>
</head>
<body>
<h3>Sentiment Analysis</h3>



<?php

$positiveprob=0.5;
$negativeprob=0.5;

$positivecount=112434;//str_word_count(file_get_contents("positive.txt"));
$negativecount=111623;str_word_count(file_get_contents("negative.txt"));

$posdenom=($positivecount+$positivecount+$negativecount);
$negdenom=($positivecount+$negativecount+$negativecount);

//echo $positivecount."  ".$negativecount;

$poscount=array();
$negcount=array();
function positivecount($word){
$file=fopen('positive.txt', 'r');
global $poscount;
foreach($word as $x){
$count=0;
while(!feof($file)){
    $line = fgets($file);
    $wordCounts = array_count_values(str_word_count($line,1));
	$sunCount = (isset($wordCounts[$x])) ? $wordCounts[$x] : 0;
    $count=$count+$sunCount;
  }
  fseek($file, 0);
  array_push($poscount,array($x => $count));



}

fclose($file);
/*echo "<pre>";
print_r($poscount);
echo "</pre>";*/
}


function negativecount($word){
$file=fopen('negative.txt', 'r');
global $negcount; 
foreach($word as $x){
$count=0;
while(!feof($file)){
    $line = fgets($file);
    $wordCounts = array_count_values(str_word_count($line,1));
	$sunCount = (isset($wordCounts[$x])) ? $wordCounts[$x] : 0;
    $count=$count+$sunCount;
  }
  fseek($file, 0);
  array_push($negcount,array($x => $count));



}

fclose($file);
/*echo "<pre>";
print_r($negcount);
echo "</pre>";*/
}

//$string="Cheap, unpretentious, and, for this, one of my favorite breakfast joints in the country. Simply put I LOVE it here. The mixed grill, the sausage and egg on a biscuit, the home fries. This it the very definition of diner. Thank you Gab 'n' Eat!";
//$string="Good Luck getting a seat, that's all I have to say. The Gab and Eat is famous and infamous. Diner food is what's up and I like it. When I was a roofing mechanic, we'd meet there before work. Although I'm not sure I would recommend it if you're working were there's no bathrooms. hehe";
$string=urldecode($_POST['text1']);
echo "<p>";
echo $string;
echo "</p>";	

$word= preg_split("/[^a-zA-Z']/", strtolower($string));

$word=array_unique($word,SORT_REGULAR);

$stopwords=array('themselves', 'while', 'yours', 'them', 'most', 'or', 'will', 'down', 'himself', 'has', 'our', 'than', 'as', 'been', 'off', 'we', 'am', 'over', 'each', 'once', 'again', 'all', 'yourself', 'there', 'just', 'what', 'this', 'being', 'for', 'were', 'have', 'theirs', 'between', 'he', 'was', 'his', 'to', 'few', 'itself', 'herself', 'no', 's', 'a', 'any', 'doing', 'those', 'how', 'do', 'until', 'had', 'below', 'both', 'they', 'during', 'own', 'more', 'why', 'only', 't', 'about', 'of', 'such', 'at', 'does', 'against', 'before', 'him', 'too', 'into', 'should', 'her', 'where', 'other', 'when', 'which', 'it', 'under', 'because', 'from', 'ourselves', 'is', 'its', 'myself', 'an', 'my', 'after', 'here', 'in', 'your', 'with', 'further', 'can', 'she', 'whom', 'out', 'i', 'hers', 'yourselves', 'same', 'are', 'don', 'very', 'now', 'above', 'the', 'by', 'ours', 'through', 'if', 'you', 'these', 'having', 'did', 'but', 'me', 'that', 'who', 'nor', 'be', 'some', 'and', 'up', 'so', 'on', 'their', 'then'
);	


$word=array_diff($word, $stopwords);
$word=array_values($word);
echo "<pre>";
$word=array_filter($word);
positivecount($word);
negativecount($word);
echo "</pre>";




foreach ($poscount as $x) {
	foreach ($x as $key=>$value) {
		$positiveprob=$positiveprob*(($value+1)/$posdenom);
		# code...
		

	}	# code...

}
foreach ($negcount as $x) {
	foreach ($x as $key=>$value) {
		$negativeprob=$negativeprob*(($value+1)/$negdenom);
		# code...
		

	}	# code...

}


echo "Positive ".$positiveprob;
echo "Negative ".$negativeprob;
echo "<br><br>";
if ($positiveprob>$negativeprob){
	echo "  Review is postive";

}
else{
	echo "  Review is negative";	
}

?>


</body>
</html>