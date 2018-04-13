<?php
$config = json_decode(Config::get('currentPortal')->config, true);
$components2 = $config['components2'];
$style = "";
$fontStyle = "";

if (!isset($localContentType)) $localContentType = $item->localCategory->last()->localContentType;
if (!isset($localCategory)) $localCategory = $item->localCategory->last()->localContentType;

foreach ($components2['content_type']['header']['background'] as $background) {
    if ($background['id'] == $localContentType->id) {
        if ($background['background_image'] && $background['background_color']['hex']) {
            $rgba = "rgba(" . $background['background_color']['rgba']['r'] . "," . $background['background_color']['rgba']['g'] . "," . $background['background_color']['rgba']['b'] . ", " . ($background['background_image_opacity'] / 100) . ")";
            $style = "background-image: linear-gradient(to bottom, " . $rgba . " 0%," . $rgba . " 100%), url('" . Storage::url($background['background_image']) . "');";
        } else {
            if ($background['background_image']) $style .= "background-image: url('" . Storage::url($background['background_image']) . "');";
            if ($background['background_image_opacity'] != 0) $style .= "opacity: " . ($background['background_image_opacity'] / 100) . ";";
            if ($background['background_color']['hex']) $style .= "background-color: " . $background['background_color']['hex'] . ";";
        }

        if ($background['background_image'] && !$components2['content_type']['header']['title']['color']['hex'])
            $fontStyle = "background: url('" . Storage::url($background['background_image']) . "');-webkit-background-clip: text;-webkit-text-fill-color: transparent;";
    }
}
?>

<div class="header_wrapper" style="{{ $style }}">
    <div class="header_title">
		<span>
			{{ $localCategory->label }}
		</span>
    </div>
    <!-- header_title -->
</div>
<!-- header_wrapper -->

<div class="row detail_video_wrapper">

    <div class="col-md-3 detail_title">
        <h1>
            <span>{{ $item->title }}</span>
        </h1>
    </div>
    <!-- detail_title -->

    <div class="col-md-9 detail_item">
        <div id="mediaplayer"></div>
        <div class="embed-responsive embed-responsive-16by9">
            <div id="player" class="embed-responsive-item"></div>
        </div>
        <div style="clear:both"></div>
    </div>
    <!-- detail_item -->

</div>
<!-- detail_video_wrapper -->

@section('scripts')

    <script type="text/javascript">
        $("#player").resize({
            aspectRatio: 16 / 9,
            maxHeight: 720,
            maxWidth: 1280,
            minHeight: 180,
            minWidth: 320
        });

        var player = new Clappr.Player({
            source: "{{ $video['stream']->url }}",
            parentId: "#player",
            // autoPlay: "true",
            height: "100%",
            width: "100%",
            poster: "{{ $item->preview }}"
        });
    </script>

@endsection