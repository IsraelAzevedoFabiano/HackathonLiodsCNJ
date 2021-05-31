<!DOCTYPE html><head>

<?php


define('URL',				'https://meioambiente.melhor.pro');
define('Icone',			URL . '/curupira.svg');
define('Raiz',			$_SERVER['DOCUMENT_ROOT'].'/');
define('DB',				Raiz.'../../../../../db/conectar.php');
define('Restritos',	Raiz.'../../../../globais/');
define('Globais',		Raiz.'../../globais/');

global 
	$pagina,
	$denuncia,
	$denuncias,
	$json,
	$resposta,
	$site,
	$usuario;

$denuncia = gerarGUID();
$usuario = $_COOKIE['curupiraUsuario'];

if(!$usuario){
	$guid = gerarGUID();
	setcookie('curupiraUsuario',$guid,time()+(10*365*24*60*60),"/");
	$usuario = $_COOKIE['curupiraUsuario'];
}



$site = array(
	'nome' => 'Curupira',
	'titulo' => 'Curupira'
);

$pagina = htmlspecialchars($_GET['pagina']);

denuncia();
documento();
//denuncias();

function documento(){

	metatags();
	icones();
	css();
	echo '<title>Curupira - ' . $GLOBALS['usuario'] . '</title><body>';
	topo();
	corpo();
	rodape();

}

function topo(){
	minificar('
	<header><a href="'.URL.'">Curupira</a></header>
	');
}

function corpo(){
	
	$titulo = 'Denuncie Infrações Ambientais';
	$subtitulo = 'Utilize o mapa abaixo para localizar a infração';
	$mapa = '<div id="mapa"></div>';
	if($GLOBALS['resposta']){
		$titulo = $GLOBALS['resposta'];
		$subtitulo = 'Sua denúncia recebeu um número único de protocolo, que poderá ser utilizado para acompanhamento:<br>' . $GLOBALS['denuncia'];
		$mapa = '';
	}
	
	minificar('
	<main>
		<h1>'.$titulo.'</h1>
		<h2>'.$subtitulo.'</h2>
		'.$mapa
	);
	if(!$GLOBALS['resposta']){
		minificar('
		<form id="formulario" method="post" action="'.URL.'">
			<select required id="categoria" name="categoria">
				<option value="">Selecione uma categoria</option>
				<option value="Comércio ilegal de madeira">Comércio ilegal de madeira</option>
				<option value="Corta ou poda de árvore sem autorização">Corta ou poda de árvore sem autorização</option>
				<option value="Crime contra a fauna">Crime contra a fauna</option>
				<option value="Descarte irregular de resíduos">Descarte irregular de resíduos</option>
				<option value="Desmatamento">Desmatamento</option>
				<option value="Extração de recursos minerais">Extração de recursos minerais</option>
				<option value="Invasão de áreas protegidas">Invasão de áreas protegidas</option>
				<option value="Pesca ilegal de peixes">Pesca ilegal de peixes</option>
				<option value="Poluição do ar">Poluição do ar</option>
				<option value="Poluição da água">Poluição da água</option>
				<option value="Poluição sonora">Poluição sonora</option>
				<option value="Queimadas">Queimadas</option>
				<option value="Outro">Outro</option>
			</select>
			<textarea id="descricao" name="descricao" required placeholder="Descrição da denúncia"></textarea>
			<label for="fotos">Se desejar, envie fotos:</label>
			<input type="file" name="fotos" capture id="fotos" name="foto" accept="image/png, image/jpeg" multiple>
			<input type="hidden" name="latitude" id="latitude">
			<input type="hidden" name="longitude" id="longitude">
			<input type="hidden" name="denuncia" id="denuncia" value="'.$GLOBALS['denuncia'].'">
			<input type="hidden" name="denunciante" id="denunciante" value="'.$GLOBALS['usuario'].'">
			<input type="submit" id="enviar" value="ENVIAR">
		</form>
	');
	}
	
	minificar($GLOBALS['denuncias']);
	minificar($GLOBALS['json']);
	minificar('<aside>
	<h2 id="privacidade">Política de Privacidade e Cookies</h2>
	<p>A Curupira acredita que é de total importância que seu direito à privacidade na internet seja respeitado, estamos fazendo de tudo o que está ao nosso alcance para assegurá-lo. Esta filosofia inclui todas as páginas que estão hospedadas no endereço https://meioambiente.melhor.pro. Não podemos nos responsabilizar às páginas contidas em sites de outras organizações que eventualmente possam ter links ou referências em nosso site.</p>
	<p>Nenhum dado pessoal é coletado através de nosso web site sem que você o informe, por sua livre e espontânea vontade, através de e-mail ou participando de alguma de nossas ações virtuais, ou ainda através do preenchimento de nosso formulário de cadastramento.</p>
	<p>A utilização de cookies em nosso site tem a finalidade única e exclusiva de estabelecerem-se estatísticas de acesso, sendo coletados somente dados como provedor de acesso, sistema operacional, navegador (tipo, versão, opções habilitadas e plug-ins instalados), configurações de vídeo (tamanho/resolução e quantidade de cores), data e hora do acesso e páginas acessadas. Não captamos informações como endereços de e-mail e outros dados pessoais, nem instalamos ou ativamos nenhum tipo de programa, vírus, script, trojans ou similares que possam de alguma forma comprometer sua segurança ou invadir sua privacidade. Tais estatísticas têm por propósito conhecer melhor o público que entra no site, de maneira a adequar a visualização e o acesso ao maior número de pessoas possível, além de aperfeiçoá-lo cada vez mais.</p>
	<p>As informações coletadas pelos meios acima descritos em hipótese alguma serão vendidas a quaisquer outras instituições, empresas ou pessoas. Somente funcionários autorizados e de confiança da Curupira têm acesso às mesmas. Nenhum dado é divulgado, seja em nosso site ou em nossas publicações, sem que tal possibilidade seja devidamente explicitada no momento de seu fornecimento. Mesmo no caso das seções onde é prevista a divulgação de mensagens, somente o nome e a localidade do remetente são divulgados, não sendo expostos dados como endereços, físico ou de e-mail, ou telefones de contato.</p>
	<p>Na eventualidade da contratação de agência para distribuição de nosso material, seja por necessidade ou conveniência, a escolha da mesma só será feita mediante a garantia de que esta política de privacidade seja devidamente respeitada, além do comprometimento de que as informações fornecidas são de uso único e exclusivo da Curupira, não sendo utilizadas em hipótese alguma para outros fins.</p>
	<p>Não enviamos nenhum tipo de material, seja por e-mail ou por meios físicos de postagem, sem que você opte por recebê-lo e indique tal opção ao preencher algum de nossos formulários.</p>
	<p>Nosso formulário de cadastro está hospedado em servidor seguro. Somente pessoal da Curupira estritamente autorizado tem acesso a esses dados.Caso você tenha alguma dúvida, sugestão ou problema no que diz respeito a esta política de privacidade ou ao site da Curupira como um todo, entre em contato conosco.</p>
	</aside>');
	
	echo '</main>';
}

function rodape(){
	minificar('
	<footer>
		<ol>
			<li><a href="#privacidade">Política de Privacidade</a></li>
		</ol>
	</footer>
	');
	
}

function css(){
	minificarCSS('<style>

	:root {
		--cor-verde:51,153,102;
		--cor-laranja:255,153,51;
		--cor-branca:255,255,255;
		--cor-preta:0,0,0;
	}
	
	*,
	*::before,
	*::after
	{
		border:0;
		box-sizing:border-box;
		font-style:normal;
		font-weight:normal;
		list-style:none;
		margin:0;
		outline:0;
		padding:0;
		text-decoration:none;
	}

	html{
		scroll-behavior:smooth;
	}

	body{
    background:rgba(var(--cor-verde),1);
    color:rgba(var(--cor-branca),1);
		font-weight:300;
		line-height:1.6;
		font-size:16px;
		font-family:"Montserrat",sans-serif;
		margin:0 auto;
		transition:all ease 0.3s;
	}
	
	header{
    background:
			linear-gradient(
				rgba(var(--cor-branca),0.1),
				rgba(var(--cor-verde),0.1)
			),
			rgba(var(--cor-branca),1)
			;
		border-top:rgba(0,0,0,0) solid 1px;
		box-shadow:0 10px 20px -10px rgba(0,0,0,0.5);
		height:100px;
		margin:0 auto;
		max-width:100%;
	}

	footer{
    background:
			linear-gradient(
				rgba(var(--cor-preta),0.7),
				rgba(var(--cor-preta),0.8)
			),
			rgba(var(--cor-verde),1)
		;
		border-top:rgba(var(--cor-laranja),1) solid 5px;
		height:auto;
		margin:0 auto;
		padding:20px;
		width:100%;
		position:fixed;
		bottom:0;
	}
	
	footer ol{
		color:rgba(var(--cor-preta),0.8);
		display:block;
		font-size:1.2rem;
		margin:10px auto;
		transition:all ease 0.3s;
		max-width:960px;		
	}
	
	ul a,
	ul a:active,
	ul a:link,
	ul a:visited,
	footer a,
	footer a:active,
	footer a:link,
	footer a:visited
	{
		color:rgba(var(--cor-branca),0.9);
	}
	
	ul a:hover,
	footer a:hover
	{
		color:rgba(var(--cor-laranja),1);
	}
	
	
	
	header a,
	header a:active,
	header a:link,
	header a:visited
	{
		color:rgba(var(--cor-laranja),1);
	}
	
	header a:hover{
		color:rgba(var(--cor-verde),1);
		
	}
	
	h1,
	h2
	{
		text-align:center;
	}
	h1{
		font-size:2.5rem;
		margin:40px 10px 20px 10px;
	}

	h2{
		font-size:2rem;
		margin:20px 10px 10px 10px;
	}
	
	h1,
	h2,
	header a,
	#enviar,
	footer
	{
    font-family:"Signika Negative",sans-serif;
	}
	p{
		font-size:1.2rem;
		line-height:1.7rem;
		padding:0 0 1rem 0;
	}
	aside{
		margin:50px auto;
		width:70%;
	}
	header a{
		background:url('.Icone.') left center no-repeat;
		display:block;
		font-size:3rem;
		margin:10px auto;
		line-height:80px;
		height:80px;
		padding:0 0 0 90px;
		transition:all ease 0.3s;
		max-width:960px;
	}

	header a,
	main
	{
		max-width:960px;
	}

	main{
		margin:0 auto;
		padding-bottom:100px;
	}

	#mapa{
		border-radius:5px;
		border:rgba(var(--cor-branca),1) 2px solid;
		height:400px;
		width:90%;
		margin:20px auto;
	}

	form{
		align-items:center;
		display:flex;
		flex-flow:row wrap;
		justify-content:space-between;
		border:rgba(var(--cor-branca),1) 2px solid;
		border-radius:5px;
		width:90%;
		margin:20px auto;
		padding:20px;
		text-align:center;
	}
	
	ul{
		margin:0 auto 50px auto;
		width:100%;
		text-align:center;
	}
	
	input[type="file"],
	select,
	textarea
	{
		color:#333;
		border:rgba(var(--cor-laranja),1) 2px solid;
		border-radius:10px;
		font-family:"Montserrat",sans-serif;
		font-size:1.2rem;
		margin:20px auto 0 auto;
		padding:10px;
		width:100%;
	}

	input[type="file"]{
		color:rgba(var(--cor-clara));
		
	}

	textarea{
		height:200px;
	}
	
	select{
		height:auto;
	}
	
	textarea:focus{
		border:rgba(var(--cor-laranja),1) 2px solid;
	}
	
	#enviar{
		cursor:pointer;
		display:flex;
		border-radius:10px;
		color:rgba(var(--cor-branca),1);
		background:rgba(var(--cor-laranja),1);
		margin:40px auto 20px auto;
		padding:10px 20px;
		font-size:1.5rem;
	}

	#enviar:hover{
		color:rgba(var(--cor-verde),1);
		background:
			linear-gradient(
				rgba(var(--cor-branca),0.2),
				rgba(var(--cor-branca),0.1)
			),
			rgba(var(--cor-laranja),1)
		;
	}

	#enviar:active{
		color:rgba(var(--cor-branca),1);
		background:
			linear-gradient(
				rgba(var(--cor-branca),0.1),
				rgba(var(--cor-branca),0.2)
			),
			rgba(var(--cor-laranja),1)
		;
	}

	label{
		display:block;
		margin:30px 0 0 0;
	}
	.gm-style-iw-d{
		color:#333;		
	}
	</style>');
}

function icones(){
	minificar('
	<link href="'.URL.'f.jpg" rel="image_src">
	<link href="'.Icone.'" rel="icon" type="image/svg">
	<link href="'.Icone.'" rel="icon" type="image/svg" sizes="16x16">
	<link href="'.Icone.'" rel="icon" type="image/svg" sizes="32x32">
	<link href="'.Icone.'" rel="icon" type="image/svg" sizes="96x96">
	<link href="'.Icone.'" rel="icon" type="image/svg" sizes="192x192">
	<link href="'.Icone.'" rel="apple-touch-icon" sizes="57x57">
	<link href="'.Icone.'" rel="apple-touch-icon" sizes="60x60">
	<link href="'.Icone.'" rel="apple-touch-icon" sizes="72x72">
	<link href="'.Icone.'" rel="apple-touch-icon" sizes="76x76">
	<link href="'.Icone.'" rel="apple-touch-icon" sizes="114x114">
	<link href="'.Icone.'" rel="apple-touch-icon" sizes="120x120">
	<link href="'.Icone.'" rel="apple-touch-icon" sizes="144x144">
	<link href="'.Icone.'" rel="apple-touch-icon" sizes="152x152">
	<link href="'.Icone.'" rel="apple-touch-icon" sizes="180x180">
	<link href="'.Icone.'" rel="apple-touch-icon-precomposed">'
	);
}

function metatags(){
	
	echo '
	<meta name="robots" content="follow,index,noodp,noydir">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="theme-color" content="#FFFFFF">
	<meta name="msapplication-TileImage" content="'.Icone.'">
	<meta name="msapplication-TileColor" content="#FFFFFF">
	<meta name="msapplication-config" content="'.URL.'browserconfig.xml">
	<meta name="msapplication-TileImage" content="'.Icone.'">
	<meta name="description" content="'.$GLOBALS['subtitulo'].'">
	<meta property="og:description" content="'.$GLOBALS['subtitulo'].'">
	<meta property="og:image" content="'.Icone.'">
	<meta property="og:locale" content="pt_BR">
	<meta property="og:image:type" content="image/jpg">
	<meta property="og:image:width" content="1200">
	<meta property="og:image:height" content="1200">
	<meta property="og:type" content="article">
	<meta property="article:author" content="'.$GLOBALS['site']['nome'].'">
	<meta property="og:url" content="'.$GLOBALS['url'].'">
	<meta property="og:site_name" content="'.$GLOBALS['titulo'].'">
	<meta property="og:title" content="'.$GLOBALS['titulo'].'">
	<link href="'.$GLOBALS['url'].'" rel="canonical">
	<link href="'.URL.'manifest.json" rel="manifest">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Signika+Negative:wght@600&display=swap" rel="stylesheet"> 
	';
	

}

function minificar($codigo){
	$codigo = removerQuebrasTabulacoesEspacosDuplos($codigo);
	$codigo = preg_replace('/>\s</','><',$codigo);
	echo $codigo;
}

function minificarCSS($codigo){
	$codigo = removerQuebrasTabulacoesEspacosDuplos($codigo);
	$codigo = preg_replace('/\s:/',':',$codigo);
	$codigo = preg_replace('/:\s/',':',$codigo);
	$codigo = preg_replace('/[(]\s/','(',$codigo);
	$codigo = preg_replace('/\s[)]/',')',$codigo);
	$codigo = preg_replace('/[{]\s/','{',$codigo);
	$codigo = preg_replace('/\s[}]/','}',$codigo);
	echo $codigo;
}

function removerQuebrasTabulacoesEspacosDuplos($codigo){
	$codigo = preg_replace('/\r\n|\r|\n|\t/','',$codigo);
	$codigo = preg_replace('/\s+/',' ',$codigo);
	return $codigo;
}

function gerarGUID(){
	return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}


function denuncia(){
	
	include DB;
	$banco	= 'emtau293_curupira';
	
	$GLOBALS['denuncias'] = '<h2>Denúncias Recebidas</h2><ul>';
	
	try{
		$conectar = new PDO(
			"mysql:host=$servidor;dbname=$banco;charset=utf8",
			$usuario,
			$senha
		);

		$conectar -> setAttribute(
			PDO::ATTR_ERRMODE,
			PDO::ERRMODE_EXCEPTION
		);
	}
	catch(PDOException $erro){echo 'Error: ' . $erro->getMessage();}

	$consultar	= 'select * FROM denuncias ORDER BY data';
	$consultar	= $conectar -> query($consultar);
	
	
	
	if($consultar -> rowCount() > 0){
		foreach($consultar -> fetchAll() as $r){
			$GLOBALS['denuncias'] .= '<li><a href="#" title="'.$r['descricao'].'">'.$r['denuncia'].'</a></li>';
						$GLOBALS['json'] .= '<input class="json-denuncias" type="hidden" value="'.$r[data] . '[SEPARADOR]' . $r[denunciante] . '[SEPARADOR]' . $r[denuncia] . '[SEPARADOR]' . $r[categoria] . '[SEPARADOR]' . $r[descricao] . '[SEPARADOR]' . $r[latitude] . '[SEPARADOR]' . $r[longitude] . '">';
		}

		$GLOBALS['denuncias'] .= '</ul>';

	}


	if($_SERVER["REQUEST_METHOD"] == 'POST'){
		$denunciante	= htmlspecialchars($_POST['denunciante']);
		$denuncia			= htmlspecialchars($_POST['denuncia']);
		$latitude			= htmlspecialchars($_POST['latitude']);
		$longitude		= htmlspecialchars($_POST['longitude']);
		$descricao		= htmlspecialchars($_POST['descricao']);
		$categoria		= htmlspecialchars($_POST['categoria']);

		try{

			$conexao = new PDO(
				"mysql:host=$servidor;dbname=$banco;charset=utf8",
				$usuario,
				$senha
			);

			$conexao -> setAttribute(
				PDO::ATTR_ERRMODE,
				PDO::ERRMODE_EXCEPTION
			);
			
			
			$executar = $conexao -> prepare('
				INSERT INTO denuncias(
					denunciante,
					denuncia,
					latitude,		
					longitude,	
					descricao,
					categoria
				) 
				VALUES(
					:denunciante,
					:denuncia,
					:latitude,
					:longitude,
					:descricao,
					:categoria
				)
			');
			$executar -> execute(
				array(
					':denunciante'	=> $denunciante,
					':denuncia'			=> $denuncia,
					':latitude'			=> $latitude,
					':longitude'		=> $longitude,
					':descricao'		=> $descricao,
					':categoria'		=> $categoria
				)
			);
		}

		catch(PDOException $erro){
			echo 'Error: ' . $erro->getMessage();
		}

		$GLOBALS['resposta'] = 'Recebemos sua denúncia';
		$GLOBALS['denuncia'] = $denuncia;
		
	}

}


?>


    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjsPgIG1fVFDaaJl1L6cjYC_wH04ePrIs&libraries=&v=weekly"
      >
    </script>
    <script>
			var map, marker
			let campoLatitude = document.getElementById('latitude')
			let campoLongitude = document.getElementById('longitude')
			initMap()
      function initMap() {
        map = new google.maps.Map(document.getElementById("mapa"), {
          center: { lat: -34.397, lng: 150.644 },
          zoom: 15,
        });
        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(
            position => {
							
							let latitude = position.coords.latitude
							let longitude = position.coords.longitude
							
							campoLatitude.value = latitude
							campoLongitude.value = longitude

              pos = {
                lat: latitude,
                lng: longitude,
              };
              map.setCenter(pos);
							
							map.setOptions({ styles:  [
							{
                    featureType: "poi",
                    stylers: [{ visibility: "off" }]
                  }]})
              // Cria marcador
              marker = new google.maps.Marker({
                position: pos,
                map: map,
                draggable: true
              });
							google.maps.event.addListener(
								marker,
								'dragend',
								evento => {
									campoLatitude.value = evento.latLng.lat()
									campoLongitude.value = evento.latLng.lng()
								}
							);
            },
            () => {
              handleLocationError(true, infoWindow, map.getCenter());
            }
						
            );
	           const icons = {
                curupira: {
                  icon: "https://meioambiente.melhor.pro/m.png",
                }
              }
            let elementos = document.getElementsByClassName('json-denuncias')
            elementos = Array.from(elementos)
            let locais = []
            iterar = [].map.call(elementos, item => {
              let propriedades = item.value.split('[SEPARADOR]')
              let local = {}
              local.data = propriedades[0]
              local.texto = propriedades[4]
              local.marcador = new google.maps.LatLng(propriedades[5], propriedades[6])
              locais.push(local)
            })
						console.log('-> elementos: ',elementos)
						markers = locais.map((local) => {
              let marcador = new google.maps.Marker({
                position: local.marcador,
								icon:"https://meioambiente.melhor.pro/m.png"
              });
              let info = infowindow = new google.maps.InfoWindow({
                content: local.texto,
              })
              marcador.addListener("click", () => {
                info.open(map, marcador)
              })
              return marcador
            })
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(
          browserHasGeolocation
            ? "Error: The Geolocation service failed."
            : "Error: Your browser doesn't support geolocation."
        );
        infoWindow.open(map);
      }
			
      function obterNovaPosicao(){
        var latLng = marker.getPosition()
        return latLng.toJSON()
      }


 </script>
<script src="https://unpkg.com/@googlemaps/markerclustererplus/dist/index.min.js"></script>
  <script>
    console.log(markers)
    new MarkerClusterer(map, markers, {
    imagePath:
      "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
  });

  </script>
</body></html>