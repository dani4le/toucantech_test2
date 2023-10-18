<?php

for($i = 1; $i < 101; $i++){
	echo $i.' '.($i % 3 ? '' : 'Toucan').($i % 5 ? '' : 'Tech').'<br/>';
}