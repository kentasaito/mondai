<script>
var vars = <?php echo json_encode($vars); ?>;
var data;
var nanmonme;
var seikai_su;
var mikaito;
var date;

function kaishi()
{
	$('#test').css('display', 'block');
	$('#kekka').css('display', 'none');
	$.ajax({
		url: vars.site_url + 'mypage/setsumons/' + vars.mondai.mondai_id + '/' + vars.shutsudai_su,
		type: 'post',
		dataType: 'json',
		success: function(json){
			data = json;
			nanmonme = 0;
			seikai_su = 0;
			mondai_meter(data.mondai);
			$('#shutsudai_su').html(data.setsumons.length);
			$('#kaito').focus();
			shutsudai();
		},
	});
}

function shuryo()
{
	playAudio('shuryo');
	$('#test').css('display', 'none');
	$('#kekka').css('display', 'block');
	$('#seikai_ritsu').html(Math.floor(100 * seikai_su / data.setsumons.length));
}

function shutsudai()
{
	if (nanmonme == data.setsumons.length)
	{
		shuryo();
		return;
	}
	playAudio('shutsudai');
	mikaito = true;
	$('#kaito').val('');
	$('#nanmonme').html(nanmonme + 1);
	$('#mondai_setsumon_id').html(data.setsumons[nanmonme].mondai_setsumon_id);
	$('#span_seikai_ritsu').html(data.setsumons[nanmonme].seikai_ritsu == null ? '-' : Math.floor(100 * data.setsumons[nanmonme].seikai_ritsu) + '%');
	$('#mondaibun').html(data.setsumons[nanmonme].mondaibun);
	if (data.setsumons[nanmonme].image == undefined)
	{
		$('#image').css('display', 'none');
	}
	else
	{
		$('#image').css('display', 'inline').attr('src', vars.site_url + 'mypage/setsumon_image?filename=' + data.setsumons[nanmonme].image);
	}
	$('#seikaito').css('display', 'none');
	$('#seikaito').val(data.setsumons[nanmonme].seikaito);
	date = new Date();
}


function seikai()
{
	if (mikaito)
	{
		seikai_su++;
		$.ajax({
			url: vars.site_url + 'test/seikai/' + data.setsumons[nanmonme].setsumon_id,
			type: 'post',
			data: 'millisec=' + (new Date - date),
			success: function(json){
			},
		});
	}
	nanmonme++;
	shutsudai();
}

function fuseikai()
{
	playAudio('fuseikai');
	if (mikaito)
	{
		mikaito = false;
		$.ajax({
			url: vars.site_url + 'test/fuseikai/' + data.setsumons[nanmonme].setsumon_id,
			type: 'post',
			data: 'gokaito=' + $('#kaito').val(),
			success: function(json){
			},
		});
	}
	$('#kaito').select();
}

function check(kaito)
{
	if (kaito == data.setsumons[nanmonme].seikaito)
	{
		seikai();
	}
	else
	{
		fuseikai();
	}
}

function jido_check(kaito)
{
	if (kaito == data.setsumons[nanmonme].seikaito)
	{
		seikai();
	}
	else if ( ! data.setsumons[nanmonme].seikaito.match(kaito))
	{
		fuseikai();
	}
}

function pass()
{
	if (mikaito)
	{
		mikaito = false;
		$.ajax({
			url: vars.site_url + 'test/pass/' + data.setsumons[nanmonme].setsumon_id,
			type: 'post',
			success: function(json){
			},
		});
	}
	$('#seikaito').css('display', 'inline');
	$('#kaito').focus();
}

$(function(){
	kaishi();

	if (vars.jido_check)
	{
		$('#kaito').keyup(function(e){
			jido_check(this.value);
		});
	}
	else
	{
		$('#kaito').keydown(function(e){
			if (e.keyCode != 13 || this.value == '') return;
			check(this.value);
		});
	}
});

function mondai_meter(mondai)
{
	meter('mondai_kaito_su', mondai.kaito_su);
	meter('mondai_seikai_ritsu', 100 * mondai.seikai_ritsu);
}

function meter(id, val)
{
	var percentage = 100 * val / $('#' + id + ' .progress-bar').attr('max');
	var addClass = percentage == 100 ? 'progress-bar-info' : (percentage > 67 ? 'progress-bar-success' : (percentage > 34 ? 'progress-bar-warning' : 'progress-bar-danger'));

	$('#' + id + ' .val').html(Math.floor(val));
	$('#' + id + ' .progress-bar').css('width', percentage + '%');
	$('#' + id + ' .progress-bar').attr('class', 'progress-bar');
	$('#' + id + ' .progress-bar').addClass(addClass);
}
</script>

<h1><?php h($vars['mondai']['mondaimei']); ?></h1>
<?php load_view('flash'); ?>
<?php $row = $vars['mondai']; ?>

<a href="<?php href("mypage/mondai/{$vars['mondai']['mondai_id']}"); ?>">問題に戻る</a>

<table class="table property">
<tr>
<th>出題者</th>
<td><a href="<?php href("mypage/shutsudaisha/{$row['user_id']}"); ?>"><?php h($row['user_name']); ?></a>さん</td>
<th>設問数</th>
<td><?php h($row['setsumon_su']); ?></td>
<th>解答数</th>
<td id="mondai_kaito_su" class="meter"><?php load_view('meter', ['val' => 0, 'max' => $this->config->item('kaitosha_setsumon_kiroku_su') * $row['setsumon_su'], 'unit' => ' / '.$this->config->item('kaitosha_setsumon_kiroku_su') * $row['setsumon_su']]); ?></td>
<th>正解率</th>
<td id="mondai_seikai_ritsu" class="meter"><?php load_view('meter', ['val' => 0, 'max' => 100, 'unit' => '%']); ?></td>
</tr>
</table>

<div id="test">
<div>第<span id="nanmonme"></span>問 (全<span id="shutsudai_su"></span>問) #<span id="mondai_setsumon_id"></span> 正解率:<span id="span_seikai_ritsu"></span></div>
<div id="mondaibun" class="lead"></div>
<img id="image" class="img-thumbnail">
<input type="text" id="seikaito" class="form-control" disabled="disabled">
<input type="text" id="kaito" class="form-control">
<button type="button" class="btn btn-default" onclick="pass();">パス</button>
</div>

<div id="kekka">
<div class="lead">正解率<span id="seikai_ritsu"></span>%<div>
<button id="moichido" type="button" class="btn btn-default" onclick="kaishi();">もう一度</button>
<a href="<?php href("mypage/mondai/{$vars['mondai']['mondai_id']}"); ?>" class="btn btn-default">問題に戻る</a>
</div>
