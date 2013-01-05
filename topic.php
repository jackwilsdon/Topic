<?PHP
/*
* Chat-o-matic
* Don't know what to talk about? I've got you covered.
* List of topics can be found in topics.txt
* http://topic.jackwilsdon.tk
*/


// Maximum number of topics allowed for retrieval at once
$max_topics = 5;
$topics_to_return = 1;


// Prefix string, sent before message
$prefix = "You should talk about [topic].";
$use_prefix = true;


// JSON Output
$json_out = true;


// Status variables
$status = "ok";
$errors = array();
$meaningful_errors = true;


// Load GET parameters
if (!empty($_GET['prefix'])) // Custom prefix
{
	$prefix = $_GET['prefix'];
}
if	(!empty($_GET['use_prefix']) && // Prefix enabled
	($_GET['use_prefix'] == "true" || $_GET['use_prefix'] == "false")) // Validate options
{
	if ($_GET['use_prefix'] == "false")
	{
		$use_prefix = false;
	} else {
		$use_prefix = true;
	}
}
if	(!empty($_GET['json']) && // JSON enabled
	($_GET['json'] == "true" || $_GET['json'] == "false")) // Validate options
{
	if ($_GET['json'] == "false")
	{
		$json_out = false;
	} else {
		$json_out = true;
	}
}
if (!empty($_GET['count']) && is_numeric($_GET['count']))
{
	$value = intval($_GET['count']);
	if ($value > $max_topics)
	{
		if ($meaningful_errors) array_push($errors, "Topic number greater than 'max_topics'");
		if (!$meaningful_errors) array_push($errors, "2");
		$status = "err";
		$topics_to_return = 1;
	} else {
		$topics_to_return = $value;
	}
}


// Load topics and shuffle them
if (!file_exists("topics.txt"))
{
	if ($meaningful_errors) array_push($errors, "Missing topics.txt");
	if (!$meaningful_errors) array_push($errors, "1");
	$status = "err";
	$topics = array();
} else {
	$topics_file = file_get_contents("topics.txt");
	$topics = explode("\n", $topics_file);
	
	$shuffleCount = rand(10,20);
	for ($cS = 0; $cS < $shuffleCount; $cS++)
	{
		shuffle($topics);
	}
}


// Remove EOL stuff
for ($cT = 0; $cT < count($topics); $cT++)
{
	$topics[$cT] = str_replace("\r", "", $topics[$cT]);
}


// Select a topic
function getTopic($topics, $prefix, $prefix_enabled)
{
	$topicID = rand(0, count($topics)-1);
	if (count($topics) == 0) return "?";
	$topic = $topics[$topicID];
	if ($prefix_enabled)
	{
		$output = str_replace("[topic]", $topic, $prefix); // Replace topic wildcard with topic string
	} else {
		$output = $topic;
	}
	return $output;
}


// Output conversion
if ($json_out)
{
	$outputArray = array();
	$outputArray["status"] = $status;
	$outputArray["errors"] = $errors;
	if ($topics_to_return > 1) // Check whether to output array, or just single item
	{
		$outputArray["topics"] = array();
		for ($cT = 0; $cT < $topics_to_return; $cT++)
		{
			array_push($outputArray["topics"], getTopic($topics, $prefix, $use_prefix));
		}
	} else {
		$outputArray["topic"] = getTopic($topics, $prefix, $use_prefix);
	}
	$result = json_encode($outputArray);
} else {
	$result = $output;
}


// Output result
echo $result;

?>

