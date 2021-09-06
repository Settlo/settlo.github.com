<?php 
#Create session
if(session_id() == '' || !isset($_SESSION)) 
{
	session_start();
}
?>
<html>
	<head>
		<meta property="og:image" content="https://mechanical-might.com/mekatron/ogImage.jpg"/>
		<link rel="stylesheet" href="Styles/Style.css">
		<link rel="icon" type="image/png" href="favicon.ico"/>
		<title>Mekatron</title>
		<script src="Scripts/jquery-3.5.1.min.js"></script>
		<script src="Scripts/wavesurfer.js"></script>
		<script src="Scripts/wavesurfer.cursor.min.js"></script>
	</head>
	<body>
		<img src=<?php echo '"Backgrounds/Gothic/BG'.rand(1,7).'.jpg"' ?> id="BackgroundImage"/>
		<div class="bgOverlay bgOverlay_6"></div>
		<div>
			<div class="centerScreen goldenBebas">
				<div>
					<center>
						<div class="controlBlock">
							<div class="controlInline">
								<a id="title">MekaTron</a>
							</div>
							<div class="controlInline error">
								<?php $hour = intval(date('H')); if ($hour >= 1 && $hour < 8) echo 'Offline'; ?>
							</div>
						</div>
					</center>
					<div class="Block">
						<center>
							<div class="gWindow">
								<div class="controlInline">
									<div class="bgOverlay bgOverlay_4"></div>
									<div class="bgOver">
										<a class="goldenBebasHighlight">Tip: </a><?php
											switch(rand(0,6))
											{
												case 0:
												echo 'Maksymalna długość wypowiedzi wynosi 15 sekund.<br><br>'; break;
												case 1:
												echo 'Jeśli twój aktor mówi zbyt szybko, glitchuje się lub jego wypowiedź jest nagle przerywana,<br> rozważ podział swojej wypowiedzi na pojedyncze zdania.<br><br>'; break;
												case 2:
												echo 'Przyrostek liczbowy w menu wyboru głosu oznacza ilość iteracji.<br>Można powiedzieć, że im większa ilość iteracji, tym lepszej jakości otrzymamy głos.<br><br>'; break;
												case 3:
												echo 'Wyrazy obcojęzyczne należy pisać w sposób nieco bardziej "fonetyczny".<br>Dla przykładu zamiast "Michael Jackson" powinno się pisać "Majkel Dżekson".<br><br>'; break;
												case 4:
												echo 'Liczebniki należy pisać słownie. Dla przykładu zamiast "Po 12 godzinach..." powinno się pisać "Po dwunastu godzinach...".<br><br>'; break;
												case 5:
												echo 'Jeśli chcesz wymusić przerwy, to możesz wykorzystać do tego znaki interpunkcyjne takie jak kropka lub przecinek.<br><br>'; break;
												case 6:
												echo 'Jeśli aktor nie potrafi dobrze wymówić konkretnej litery, spróbuj zastosować jakiś zamiennik. Np. \'h\' na \'ch\' albo \'ź\' na \'ś\'<br><br>'; break;
											}
										?>
										<form id="gStandardGeneratorForm">
											<div class="mainControls labelAdjust">
												Tekst:
											</div>
											<div class="mainControls">
												<textarea id="inputText" rows='4' class="gControl gTextArea" spellcheck="false"><?php 
												echo 'Przed użyciem zapoznaj się z treścią ulotki dołączonej do opakowania bądź skonsultuj się z lekarzem lub farmaceutą, gdyż każdy lek niewłaściwie stosowany zagraża Twojemu życiu lub zdrowiu.'; ?></textarea>
											</div>
											<div class="controlBlock">
												<div class="controlRow">
													<div class="mainControls labelAdjust">
														Aktor:
													</div>
													<div class="mainControls">
														<select id="inputModel" class="gControl">
															<?php
																//$Selected = $inputSpeech;
																if (empty($Selected)) 
																	$Selected = 'Gothic_Bezi_201000';
																
																$files = glob('H:\Python\tacotron2-master\outdir\Ready\*');
																foreach($files as $file) 
																{
																	if (is_dir($file) || strpos($file,'Giel') || strpos($file,'Bowman') || strpos($file,'checkpoint'))
																		continue;
																	
																	$filename = basename($file);
																	$isSelected = $filename == $Selected ? 'selected="selected"' : '';
																	echo '<option class="optionBackground" value="'.$filename. '" '.$isSelected.'>'.$filename.'</option>';
																}
															?>
														</select>
													</div>
													<div class="gControlGenerujDiv">
														<input id="SendRequest" type="submit" value="Generuj..." class="gControl gControlIndentMod maximizeHorizontally">
													</div>
												</div>
												
												<div class="ControlRow">
													<div class="mainControls maximizeHorizontally">
														<button class="gControl gControlIndentMod maximizeHorizontally" id="playButton" disabled>Odtwórz</button>
													</div>
												</div>
												
											</div>
										</form>
									</div>
									<div id="OutputArea"></div>
									<div id="outputWaveformDiv">
										<div id="outputWaveform"></div>
									</div>
									<div id="QueuePosInfoDiv"></div>
								</div>
							</div>
						</center>
						<div id="InfoButton">
							<img src="Controls/Info.svg" width="20">
							<div id="InfoButtonTextContainer">
								Maksymalna ilość znaków: 500<br>
								Maksymalna długość głosu: 15s<br><br>
								Ze względu na naukę nowych głosów<br>
								Mekatron w godzinach 01:00 - 08:00 jest niedostępny.
							</div>
						</div>
					</div>
				</div>
				<div id="socialLinkContainer" class="controlBlock centerRelHorizontally">
					<a class="controlInline" href="#" target="_blank">
						<div class="smPush gSocialTab gSocialTabBorder">
							<img src="SocialMedia/Ko-Fi.svg" class="gSocialTabImage">
						</div>
					</a><a class="controlInline" href="#" target="_blank">
						<div class="smPush gSocialTab gSocialTabBorder">
							<img src="SocialMedia/YouTube.svg" class="gSocialTabImage">
						</div>
					</a><a class="controlInline" href="#" target="_blank">
						<div class="smPush gSocialTab gSocialTabBorder">
							<img src="SocialMedia/SoundCloud.svg" class="gSocialTabImage">
						</div>
					</a><a class="controlInline" href="#" target="_blank">
						<div class="smPush gSocialTab gSocialTabBorder">
							<img src="SocialMedia/Newgrounds.svg" class="gSocialTabImage">
						</div>
					</a><a class="controlInline" href="https://github.com/NVIDIA/tacotron2" target="_blank">
						<div class="smPush gSocialTab  gSocialTabBorder">
							<img src="SocialMedia/Github.svg" class="gSocialTabImage">
						</div>
					</a><a class="controlInline" href="https://discord.gg/S9dmsWBTha" target="_blank">
						<div class="smPush gSocialTab gSocialTabBorder">
							<img src="SocialMedia/Discord.svg" class="gSocialTabImage">
						</div>
					</a><a class="controlInline" href="https://www.facebook.com/MekatronAI/" target="_blank">
						<div class="smPush gSocialTab">
							<img src="SocialMedia/Facebook.svg" class="gSocialTabImage">
						</div>
					</a>
				</div>
			</div>
		</div>
		<div id="gFooterContactInfo" class="goldenBebas">kontakt@moja-strona.com</div>
		<?php
			echo '<div id="gFooterNotice" class="goldenBebas"><div class="smallHeader">Warunki korzystania z aplikacji Mekatron</div><div class="underHeaderBody"><div>Mekatron został stworzony z myślą o tworzeniu treści humorystycznych oraz modyfikacji do gier. Wszelkie prawa do głosów oraz wykorzystywanych próbek należą do ich prawowitych właścicieli.<br>Wykorzystywanie wygenerowanych materiałów w celach komercyjnych, kradzieży tożsamości lub łamiących w jakikolwiek sposób polskie prawo jest surowo zabronione.<br>Wszelkie próby exploitowania programu lub działania na niekorzyść właściciela będą skutkowały natychmiastowym ograniczeniem dostępu do aplikacji.<br>Akceptując powyższe warunki oświadczasz, iż zapoznałeś się z powyższymi zasadami i jesteś świadom pełnej odpowiedzialności za tworzone przez Ciebie treści przy pomocy narzędzia Mekatron.</div> <div id="footerButtonContainer"><button id="termsAccept" class="footerButton">Akceptuję</button><button id="termsReject" class="footerButton">Odrzucam</button></div> </div></div>';
		?>
		<script src="Scripts/MobilePerformance.js"></script>
		<script src="Scripts/TermsOfUse.js"></script>
		<script src="Scripts/Delay.js" multiplier="0"></script>
		<script src="Scripts/TextAreaAutosize.js"></script>
		<script src="Scripts/Queue.js"></script>
		<script src="Scripts/InfoButton.js"></script>
	</body>
</html>