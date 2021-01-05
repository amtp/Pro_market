<?php
$current = $data['current'];
$fiveDays = $data['fiveDays'];
$enablednow = count($current) > 0;
$enabledFiveDays = count($fiveDays) > 0;
?>

<div class="gradus">
<small><a href="/pogoda">погода на 5 дней</a></small>
<?php echo round($current['temp'],0); ?> <sup>o</sup>C </span>
</div>
<img src="<?php echo $current['icon']?>" alt="<?php echo $current['description']?>" title="<?php echo $current['description']?>">




