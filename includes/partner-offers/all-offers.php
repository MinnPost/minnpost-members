<h1>Partner Offers</h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
 <input type="hidden" value="<?php echo $local_id; ?>" name="contact_id" id="contact_id">
<ol class="partner-offers">
<?php
while ($offer = $result->fetch_assoc()) {
    $partner = $offer['name'];
    $event = $offer['event'];
    $title = $partner;

    if ($partner === $event) {
    	$subtitle = '';
    } else {
    	$subtitle = $event;
    }

    if ($offer['offer_image_url'] !== NULL) {
    	$src = $offer['offer_image_url'];
    } else if ($offer['partner_image_url'] !== NULL) {
    	$src = $offer['partner_image_url'];
    }

    if ($offer['instance_count'] > 1) {
    	// get the dates and date display option here.
    	$id = $offer['offer_id'];
    	$get_instances = "SELECT * FROM offer_instances WHERE offer_id='$id' ORDER BY event_use_start, event_use_end";
    	if (!$instances = $db->query($get_instances)) {
	        die('There was an error running the query [' . $db->error . ']');
	    }
    }

    echo '<li class="clearfix">';
    	if (isset($src)) {
    		echo '<div class="img"><img src="' . $src . '" alt="' . $title . '"></div>';
    	}
	    echo '<div class="info">';
	    if ($offer['offer_image_url'] !== NULL) {
	    	echo '<h2>' . $title . '</h2>';
	    }
	    echo '<h3><span class="event">' . $subtitle . '</span></h3>';
	    echo '<h4><span class="offer">' . $offer['quantity'] . ' ' . ucwords($offer['item_type'])	 . '</span></h4>';
	    if ($offer['instance_count'] > 1) {
	    	$btnvalue = '';
	    	echo '<select name="instance_id" id="instance_id">
	    		<option value="">Select an option</option>';
	    		$options = '';
	    		$num = 1;
	    		$claimed = '';
	    		while ($instance = $instances->fetch_assoc()) {
	    			if ($instance['claimed'] !== NULL) {
	    				$claimed = $instance['claimed'];
	    			}
	    			$start = date('F j, Y', strtotime($instance['event_use_start']));
	    			$end = date('F j, Y', strtotime($instance['event_use_end']));
	    			if ($instance['event_use_end'] !== NULL && $instance['date_display'] !== NULL) {
	    				if ($instance['date_display'] == 'all') {
	    					$options .= '<option value="' . $instance['id'] . '">' . $start . ' - ' . $end . '</option>';
	    				} else if ($instance['date_display'] == 'startend' && $num == 1) {
	    					$options .= '<option value="' . $instance['id'] . '">' . $start . ' - ';
	    				} else if ($instance['date_display'] == 'startend' && $num == $offer['instance_count']) {
	    					$options .= $end . '</option>';
	    				} else if ($instance['date_display'] == 'start' && $num == 1) {
	    					$options .= '<option value="' . $instance['id'] . '">' . $start . '</option>';
	    				} else if ($instance['date_display'] == 'end' && $num == $offer['instance_count']) {
	    					$options .= '<option value="' . $instance['id'] . '">' . $end . '</option>';
	    				}
	    			} else if ($instance['event_use_end'] !== NULL) {
	    				$options .= '<option value="' . $instance['id'] . '">' . $start . ' - ' . $end . '</option>';
	    			} else {
	    				$options .= '<option value="' . $instance['id'] . '">' . $start . '</option>';
	    			}
	    			$num++;
	    		}
				echo $options;	    		
	    	echo '</select>';
	    } else if ($offer['instance_count'] == 1) {
	    	$id = $offer['offer_id'];
	    	$instance = "SELECT * FROM offer_instances WHERE offer_id='$id'";
	    	$btnvalue = ' name="instance_id" value="' . $offer['instance_id'] . '"';
	    	if ($offer['claimed'] !== NULL) {
				$claimed = $instance['claimed'];
			}
	    	$start = date('F j, Y', strtotime($offer['event_use_start']));
	    	$end = date('F j, Y', strtotime($offer['event_use_end']));
	    	$date = '<p class="date">';
	    	if ($offer['event_use_end'] !== NULL && $offer['date_display'] !== NULL) {
				if ($offer['date_display'] == 'all') {
					$date .= $start . ' - ' . $end;
				} else if ($offer['date_display'] == 'start') {
					$date .= $start;
				} else if ($offer['date_display'] == 'end') {
					$date .= $end;
				}
			} else if ($offer['event_use_end'] !== NULL) {
				$date .= $start . ' - ' . $end;
			} else {
				$date .= $start;
			}
			$date .= '</p>';
	    	echo '<p>' . $date . '</p>';
	    }
	    if ($offer['restriction'] !== NULL) {
	    	echo '<small class="restriction">' . $offer['restriction'] . '</small>';
	    }
	    echo '<p class="actions">';
	    if ($eligible == TRUE && $member == TRUE) {
	    	if ($claimed == FALSE) {
	    		echo '<button class="btn btn--final" type="submit"' . $btnvalue . '>Claim Offer</button>';
	    	} else {
	    		echo '<button class="btn btn--disabled" disabled' . $btnvalue . '>All Claimed</button>';
	    	}
	    } else if ($eligible == FALSE && $member == TRUE) {
	    	echo '<strong>You may not claim another partner offer until ' . date('F j, Y', strtotime($next_partner_claim)) . '</strong>';
	    } else if ($member == FALSE) {
	    	echo '<a href="http://www.minnpost.com/support/member-benefits?level=gold" class="btn btn--final">Support MinnPost for eligibility</a>';
	    }

	    if ($offer['more_info_url'] !== NULL && $offer['more_info_text'] !== NULL) {
	    	echo '<div><a href="' . $offer['more_info_url'] . '">' . $offer['more_info_text'] . '</a></div>';
	    }

	    echo '</p>';
	    echo '</div>';
	echo '</li>';
}
?>
</ol>
</form>