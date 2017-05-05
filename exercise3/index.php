<html>
 <head>
  <title>PHP Exercise 3</title>
 </head>
 <body>
<?php

		// EXERCISE: Using two datasets of 10,000 randomly generated values between 1 and 10,000 find only those that are common between the two datasets and sort them from least to greatest. Do not use array_intersect() or array_unique() while answering this question. The final goal is to come up with the fastest way possible to accomplish this task.

		function merge($data) {

			if (count($data) > 1) {
				
				$data_center = round(count($data) / 2, 0, PHP_ROUND_HALF_EVEN);
				$first_half = merge(array_slice($data, 0, $data_center));
				$second_half = merge(array_slice($data, $data_center, count($data)));

				$counter1 = 0;
				$counter2 = 0;

				for ($i=0; $i < count($data); $i++) {

					if ($counter1 == count($first_half)) {
						$data[$i] = $second_half[$counter2];
						++$counter2;

					} elseif (($counter2 == count($second_half)) or ($first_half[$counter1] < $second_half[$counter2])) { 
						$data[$i] = $first_half[$counter1];
						++$counter1;

					} else {
						$data[$i] = $second_half[$counter2];
						++$counter2;
					}
				}
			}
			return $data;
		}

		$start = microtime(true);

		// Generate the two datasets
		for ($i=0; $i < 10000; $i++){
			$dataset1[] = mt_rand(1, 10000);
		}

		for ($i=0; $i < 10000; $i++){
			$dataset2[] = mt_rand(1, 10000);
		}

		// Remove duplicate data from each individual dataset

		$trimmed_dataset1 = array();
		for ($i=0; $i < 10000; $i++){
			if (!in_array($dataset1[$i], $trimmed_dataset1))
				$trimmed_dataset1[$dataset1[$i]] = $dataset1[$i];
		}

		$trimmed_dataset2 = array();
		for ($i=0; $i < 10000; $i++){
			if (!in_array($dataset2[$i], $trimmed_dataset2))
				$trimmed_dataset2[] = $dataset2[$i];
		}

		// Find common values
		$count = count($trimmed_dataset2);

		for ($i=0; $i < $count;$i++) {
			if (array_key_exists($trimmed_dataset2[$i], $trimmed_dataset1))
				$common[] = $trimmed_dataset2[$i];
		}

		$data = merge($common);
		$common_values = count($data);
		$execution_time = $time_elapsed_secs = microtime(true) - $start;
		?>
		
		<p><strong>Common Values: </strong><?php echo $common_values ?></p>
		<p><strong>Execution Time: </strong><?php echo $execution_time ?></p>
		<p><strong>Output: </strong></p>
		<p><?php print_r($data) ?></p>	

 </body>
</html>