Topic
=====
Stuck for what to talk about? Topic can help. Topic retrieves pre-set conversation topics from a file, and returns them in an api-like format.

Visit [my website](http://topic.jackwilsdon.tk/) for more documentation and an example.

Usage
-----
 - `prefix=[prefix]` - Set the prefix to be returned with the topic. Default: `You should talk about [topic]`.
 - `use_prefix=[true/false]` - Set whether a prefix should be returned with the topic. Default: `true`.
 - `json=[true/false]` - Should the data be returned in JSON format? **Note**: If data is not returned in JSON format, count will be ignored. Default: `true`.
 - `count=[number]` - Set the number of topics to be retuned (JSON only). Default: `1`.
 
Example
-------
**Query**

`generate?count=3&use_prefix=false`

**Result**

    {
        status: "ok",
        errors: [ ],
        topics: [
            "your favourite / best memory",
            "school",
            "whether you prefer cats or dogs"
        ]
    }
	
Error Codes
-----------
 - `1` - `count` exceeds `$max_topics`. Either decrease your `count`, or increase `$max_topics` inside `topic.php`.