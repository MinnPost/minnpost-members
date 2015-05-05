<h1>Partner Offers</h1>
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
    echo '<li class="clearfix">';
    	if (isset($src)) {
    		echo '<div class="img"><img src="' . $src . '" alt="' . $title . '"></div>';
    	}
	    //echo '<h2>' . $title. '</h2>';
	    echo '<h3><span class="event">' . $subtitle . '</span></h3>';
	    echo '<h4><span class="offer">' . $offer['quantity'] . ' ' . ucwords($offer['item_type'])	 . '</span></h4>';

	echo '</li>';
}
?>
</ol>