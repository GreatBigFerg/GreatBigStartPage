<?php
include_once('../include/config.php');
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

//  //
class gui {
	public $view = "podcast";
	function set_view($str) {
		$this->view = $str;
		return $this->view;
	}
}

class search {
	function submit() {
		echo 'go';
	}
}

//  //
class podcast {
    
    function get_list() {
		global $conn;
        $records = array();
        $query = mysqli_query($conn, "SELECT * FROM podcast WHERE id IS NOT null");
        if (!$query) {
		    return false;
	    } else {
		    while ($rows = mysqli_fetch_array($query)) {
				$info = array();
				$info['number'] = $rows['number'];
				$info['title'] = $rows['title'];
				$info['date'] = $rows['date'];
				$info['length'] = $rows['length'];
				$info['guest'] = $rows['guest'];
				$info['topics'] = $rows['topics'];
				$info['description'] = $rows['description'];
			    $records[$rows['id']] = $info;
		    }
	    }
	    return $records;
    }

    function new_entry() {
        global $conn;
		$number = filter_var($_POST['number'], FILTER_SANITIZE_INT);
		$title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
		$guest = filter_var($_POST['date'], FILTER_SANITIZE_STRING);
		$guest = filter_var($_POST['length'], FILTER_SANITIZE_STRING);
		$guest = filter_var($_POST['guest'], FILTER_SANITIZE_STRING);
		$topics = filter_var($_POST['topics'], FILTER_SANITIZE_STRING);
		$description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
		$sql = "INSERT INTO podcast (number, title, guest, topics, description) VALUES ('$number', '$title', '$guest', '$topics', '$description')";
	    $query = mysqli_query($conn, $sql);
	    if (!$query) {
		    echo mysqli_error($conn);
        	$msg = "An error was encountered while uploading your file, please try again.";
    	} else {
			$msg = "File uploaded successfully!";
        }
	    echo "<meta http-equiv='refresh' content='0'>";
	    echo "<script> alert('".$msg."');</script>";
	}
	
	function filter_list($filter, $option) {
		global $conn;
		$query_filter = "";
		switch($filter) {
			case "number":
				$query_filter = "number = '".$option."'";
				break;        
			case "title":
				$query_filter = "title = '".$option."'";
				break;
			case "guest":
				$query_filter = "guest = '".$option."'";
				break;
			case "topics":
				$query_filter = "topics = '".$option."'";
				break;
		}
		$sql = "SELECT * FROM podcast WHERE ".$query_filter;
		$query = mysqli_query($conn, $sql);
		if (!$query) {
		    return false;
	    } else {
		    while ($rows = mysqli_fetch_array($query)) {
				$info = array();
				$info['number'] = $rows['number'];
				$info['title'] = $rows['title'];
				$info['guest'] = $rows['guest'];
				$info['topics'] = $rows['topics'];
				$info['description'] = $rows['description'];
			    $records[$rows['id']] = $info;
		    }
	    }
	    return $records;
	}
}

//  //
class guest {
    
    function get_list() {
        global $conn;
        $records = array();
        $query = mysqli_query($conn, "SELECT * FROM guest WHERE id IS NOT null");
        if (!$query) {
		    return false;
	    } else {
		    while ($rows = mysqli_fetch_array($query)) {
				$info = array();
				$info['name'] = $rows['name'];
				$info['age'] = $rows['age'];
				$info['sex'] = $rows['sex'];
				$info['profession'] = $rows['profession'];
				$info['description'] = $rows['description'];
				$info['appearances'] = $rows['appearances'];
			    $records[$rows['id']] = $info;
		    }
	    }
	    return $records;
    }

    function new_entry() {
        echo "***";
    }
}

//  //
class topic {
    
    function get_list() {
        global $conn;
        $records = array();
        $query = mysqli_query($conn, "SELECT * FROM topics WHERE id IS NOT null");
        if (!$query) {
		    return false;
	    } else {
		    while ($rows = mysqli_fetch_array($query)) {
				$info = array();
				$info['name'] = $rows['name'];
				$info['description'] = $rows['description'];
				$info['category'] = $rows['category'];				
				$info['appearances'] = $rows['appearances'];
			    $records[$rows['id']] = $info;
		    }
	    }
	    return $records;
    }

    function new_entry() {
        echo "***";
    }
}

// Handles video-specific operations //
class video {
    // Return multi-dementianal array of only movies in the DB  //
    function get_movie_list() {   
	    global $conn;
        $records = array();
        $query = mysqli_query($conn, "SELECT * FROM video_data WHERE FileExists = 'true'");
        if (!$query) {
		    return false;
	    } else {
		    while ($rows = mysqli_fetch_array($query)) {
			    $info = array();
				$info['title'] = $rows['Title'];
				$info['length'] = $rows['Length'];
			    $info['genre'] = $rows['Genre'];
			    $records[$rows['id']] = $info;
		    }
	    }
	    return $records;
    }
    // Return multi-dementianal array of only TV-shows/series in the DB //
    function get_series_list() {
	    global $conn;
        $records = array();
        $query = mysqli_query($conn, "SELECT id, Title, ProgramName, SeasonNumber, EpisodeNumber, Genre FROM video_data WHERE ProgramName IS NOT NULL AND FileExists = 'true'");
        if (!$query) {
		    return false;
	    } else {
		    while ($rows = mysqli_fetch_array($query)) {
			    $info = array();
			    $info['title'] = $rows['Title'];
			    $info['show'] = $rows['ProgramName'];
			    $info['season'] = $rows['SeasonNumber'];
			    $info['episode'] = $rows['EpisodeNumber'];
			    $info['genre'] = $rows['Genre'];
			    $records[$rows['id']] = $info;
		    }
	    }
	    return $records;
    }
    // Return multi-dementianal array of all videos in the DB //
    function get_video_list() {
	    global $conn;
        $records = array();
        $query = mysqli_query($conn, "SELECT * FROM video_data WHERE FileExists = 'true'");
	    if (!$query) {
		    return false;
	    } else {
		    while ($rows = mysqli_fetch_array($query)) {
			    $info = array();
			    $info['title'] = $rows['Title'];
			    $info['show'] = $rows['ProgramName'];
			    $info['season'] = $rows['SeasonNumber'];
			    $info['episode'] = $rows['EpisodeNumber'];
			    $info['genre'] = $rows['Genre'];
			    $records[$rows['id']] = $info;
		    }
	    }
	    return $records;
    }
    // Return array of existing genres for videos in the DB //
    function get_genre_list() {
	    global $conn;
        $records = array();
		$query = mysqli_query($conn, "SELECT Genre FROM video_data WHERE FileExists = 'true'");			    
	    while ($rows = mysqli_fetch_array($query)) {
		    $records[$rows['Genre']];
	    }
	    return $records;
	}
	// Get input from user and handle new file upload, creating new record in the DB //
    function new_upload() {
		global $conn;
        $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);	
		$isseries = filter_var($_POST['isseries'], FILTER_SANITIZE_STRING);
		if ($isseries == 1) {
			$seriestitle = filter_var($_POST['seriestitle'], FILTER_SANITIZE_STRING);
			$season = filter_var($_POST['season'], FILTER_SANITIZE_NUMBER_INT);
			$episode = filter_var($_POST['episode'], FILTER_SANITIZE_NUMBER_INT);
			$season_episode = $season."-".$episode;
		} else {
			$seriestitle = " ";
			$season = " ";
			$episode = " ";
			$season_episode = " ";
		}
	    $genre = filter_var($_POST['genre'], FILTER_SANITIZE_STRING);
	    $upload = $_FILES["video_uploaded_file"];
        $fu = new upload();
        $fu->file = $upload;
        if ($fu->move_upload()) {
            $fu->file_info();
            $fname = $fu->filename;
            $fdir = $fu->dir;
            $fext = $fu->ext;
	        $sql = "INSERT INTO video_data (Title, SeriesTitle, Series_Episode, Genre, FileName, FilePath, FileFormat, FileExists) 
                VALUES ('$title', '$seriestitle', '$season_episode', '$genre', '$fname', '$fdir', '$fext', 'true')";
	        $query = mysqli_query($conn, $sql);
	        if (!$query) {
		        echo mysqli_error($conn);
	        }
            $msg = "File uploaded successfully!";
        } else {
            $msg = "An error was encountered while uploading your file, please try again.";
        }
	    echo "<meta http-equiv='refresh' content='0'>";
	    echo "<script> alert('".$msg."');</script>";
	}
	// //
	//function edit_record() {

	//}
}


// Temporary function for filtering results shown //
function filter_results($results, $table, $filter, $option) { 
    $array = array();
    $query_filter = "";
    switch($filter) {
        case "genre":
            $query_filter = "Genre = '".$option."'";
            break;        
        case "artist":
            $query_filter = "Artist = '".$option."'";
            break;
        case "album":
            $query_filter = "Album = '".$option."'";
            break;
        case "owner":
            $query_filter = "Owner = '".$option."'";
            break;
        case "favorite":
            $query_filter = "Favorite = '".$option."'";
            break;
    }
    foreach ($results as $rid => $title) {
        $sql = "SELECT id, Title FROM ".$table." WHERE ".$query_filter;
        $query = mysqli_query($conn, $sql);
        while($rows = mysqli_fetch_array($query)) {
            $array[$rows['id']]=$rows['MediaTitle'];
        }
    }
    return $array;
}

// Download DB info as CSV file //
function create_csv() {
	$sql="SELECT * FROM active_requests";
	$result = mysqli_query($conn, $sql);
	$num_column = mysqli_num_fields($result);		
	$csv_header = '';
	for($i=0;$i<$num_column;$i++) {
		$csv_header .= '"' . mysqli_fetch_field_direct($result,$i)->name . '",';
	}	
	$csv_header .= "\n";
	$csv_row ='';
	while($row = mysqli_fetch_row($result)) {
		for($i=0;$i<$num_column;$i++) {$csv_row .= '"' . $row[$i] . '",';}
		$csv_row .= "\n";
	}	
	/* Download as CSV File */
	header('Content-type: application/csv');
	header('Content-Disposition: attachment; filename=active_request.csv');
	echo $csv_header . $csv_row;
	exit;
}