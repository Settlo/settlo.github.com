var wavesurfer = WaveSurfer.create({
    container: '#outputWaveform',
    waveColor: '#ddd',
	cursorColor: 'fff',
	plugins: [WaveSurfer.cursor.create()],
	mediaControls: true,
    progressColor: '#d4ca98'
});
wavesurfer.on('seek', function () {
	if (wavesurfer.isPlaying())
		wavesurfer.play();
});
wavesurfer.load('gens/7581409883.wav');