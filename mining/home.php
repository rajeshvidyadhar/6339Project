<!--
1. Analyzing Sentiment of Movie Review Data using Naive Bayes Neural Classifier. Lina L. Dhande, Dr. Prof. Girish K Patnaik. 4, SSBT’s College of Engineering and Technology, Bambhori, Jalgaon, Maharashtra, India : International Journal of Emerging Trends & Technology in Computer Science (IJETTCS), 2014, http://www.ijettcs.org/Volume3Issue4/IJETTCS-2014-08-25-138.pdf, Vol. 3. 2278-6856.
2. Yelp Dataset Challenge. Yelp.com. [Online] [Cited: 04 03, 2015.] http://www.yelp.com/dataset_challenge.
3. SemEval 2015. alt.qcri.org. [Online] [Cited: 04 03, 2015.] Aspect Based Sentiiment Analysis : Idea obtained from here. http://alt.qcri.org/semeval2015/task12/.
4. SemEval-2014 ABSA Restaurant Reviews - Train Data. Meta Share. [Online] [Cited: 04 03, 2015.] Training Data for Aspect Based Sentiment Analysis Obtained here. http://metashare.ilsp.gr:8080/repository/browse/semeval-2014-absa-restaurant-reviews-train-data/479d18c0625011e38685842b2b6a04d72cb57ba6c07743b9879d1a04e72185b8/.
5. Barber, Ian. Bayesian Opinion Mining. PHP/ir. [Online] 01 01, 2010. [Cited: 04 03, 2015.] Training Data set for regular Sentiment Analysis and the Naive Bayes concept of Sentiment Analysis learnt from here. http://www.phpir.com/bayesian-opinion-mining/
-->
<html>
<head>
    <title>Project 4</title>
</head>
<body>
<h1>Semester Long Project Data Mining</h1>
<label>Select a City</label> 
    <form action="extract.php" method="POST">
        <select name="state" onchange="window.location='home.php?state='+this.value" >
        <option value='0' selected="selected">None</option>
<?php
ini_set('max_execution_time', 500000);
try 
{
    $m = new MongoClient(); // connect
    $db = $m->mining;
    $coll=$db->business;
    $state=$coll->distinct( "city" );
    foreach ($state as $val) {
        echo "<option value=".$val.">".$val."</option>";
    }

    echo "</select>";
    echo "</form>";

    if(isset($_GET['state'])){
        echo "Restaurants in ".$_GET['state'];
        
            echo "<form method='POST' action='extract.php' >";
            echo "<select name=rest>";
            $query=array("city"=>$_GET['state']);
            $cur=$coll->find($query);
            foreach ($cur as $x) {
                if(in_array('Restaurants', $x['categories'])){
                    

                echo "<option value=".$x['business_id'].">".$x['name']."</option>";
                }
            }
            echo "</select>";
            echo "<input type='submit' value=Submit>";
            echo "</from>";
        }

    
    
}
catch ( MongoConnectionException $e ) 
{
    echo '<p>Couldn\'t connect to mongodb, is the "mongo" process running?</p>';
    exit();
}



?>


        
</body>
</html>