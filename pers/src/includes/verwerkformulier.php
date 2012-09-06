<?php
function verwerk($invoer,&$object){
		// status ok totdat tegendeel bewezen is, terug te geven velden initialiseren 
		$result = array(ok => true, velden => '');														// algemene status ok
		foreach($invoer as $init => $inhoud){															// voor ieder veld op formulier
			if($_POST[$invoer[$init]['naam']] == $init && $inhoud['type'] != 'submit' ){ 	            // geen waarde ingevuld?															// status veld ok
				$_POST[$invoer[$init]['naam']] = "";													// leegmaken voor controle
			}
			if($invoer[$init]['controle'] != ''){														// controle functie 
				if(!$invoer[$init]['controle']($_POST[$invoer[$init]['naam']])){						// controle fout?
					$invoer[$init]['status'] = 'notok';													// status veld notok
					$result['ok'] = false;																// algemene status notok
				}
			}
	
			if($invoer[$init]['status'] == 'ok'){														// veld goed?
				if ($invoer[$init]['setter'] != ''){													// setter ingevuld?
					$object->$invoer[$init]['setter']($_POST[$invoer[$init]['naam']]);					// set waarde in object
				}	
			}
			
			switch($invoer[$init]['type']){		
				case 'image':
					break;		
				case 'submit':
					break;
				case 'select':
					foreach($invoer[$init]['waarde'] as $waarde => $omschrijving){							
						if ($waarde == $_POST[$invoer[$init]['naam']]){								// vergelijk mogelijke waarde met invoer
							$invoer[$init]['waarde'][$waarde][1] = 'selected';						// indien gelijk zet selected
						} else {
							$invoer[$init]['waarde'][$waarde][1] = '';								// indien ongelijk selected op null
						}
					}
					break;
				default:
					$invoer[$init]['waarde'] = $_POST[$invoer[$init]['naam']];						// zet waarde op het formulier				
			}		
		}
		$result['velden'] = $invoer;																	// invoer velden naar result tabel
		return $result;
}
		
function initNietIngevuld($invoer){

		foreach($invoer as $init => $inhoud){															 // voor veld op formuier
			if(($inhoud['waarde'] == "" || $inhoud['waarde'] == $init) && $inhoud['type'] != 'submit' && $inhoud['type'] != 'select' ){ // als niet ingevuld og gelijk omschrijving en geen button
				$invoer[$init]['waarde'] = $init;														 // waarde wordt omschrijving
				$invoer[$init]['status'] = 'init';														 // status wordt init
				if ($inhoud['verplicht'] && isset($_POST['command_x'])){									 // verplicht veld?
					$result['ok'] = false;																 // zo ja fout
					$invoer[$init]['status'] = 'notok';													 // status veld = fout
				} 
			}
		}
		return 	$invoer;
}
?>