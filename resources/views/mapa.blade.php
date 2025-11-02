<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mapa Geoespacial - GeoApp</title>
    
    <!-- ArcGIS Maps SDK for JavaScript 4 -->
    <link rel="stylesheet" href="https://js.arcgis.com/4.35/esri/themes/light/main.css">
    <script src="https://js.arcgis.com/4.35/"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden;
        }

        #container-mapa {
            width: 100vw;
            height: 100vh;
        }

        .loader {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            display: none;
        }

        .loader.ativo {
            display: block;
        }

        .esri-view {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .esri-popup__header-title {
            font-size: 16px;
            font-weight: 600;
        }

        .titulo-pagina {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 100;
            background: white;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            font-size: 24px;
            font-weight: 600;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="titulo-pagina">🗺️ GeoApp - Mapa Geoespacial</div>
    
    <div class="loader" id="carregador-mapa">
        <p style="text-align: center; margin-bottom: 10px;">Carregando mapa...</p>
        <div style="border: 3px solid #f3f3f3; border-top: 3px solid #3498db; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; margin: 0 auto;"></div>
    </div>

    <div id="container-mapa"></div>

    <style>
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <script>
        require([
            "esri/Map",
            "esri/views/MapView",
            "esri/layers/GraphicsLayer",
            "esri/layers/FeatureLayer",
            "esri/widgets/Legend",
            "esri/widgets/Expand",
            "esri/PopupTemplate",
            "esri/Graphic"
        ], function(
            Map, MapView, GraphicsLayer, FeatureLayer, Legend, Expand, PopupTemplate, Graphic
        ) {
            
            // Criar o mapa
            const mapa = new Map({
                basemap: "topo-vector"
            });

            // Criar a visualização do mapa centralizada no Brasil
            const visualizacaoMapa = new MapView({
                container: "container-mapa",
                map: mapa,
                center: [-47.88, -15.79], // Centro do Brasil
                zoom: 4
            });

            // Mostrar loader
            document.getElementById('carregador-mapa').classList.add('ativo');

            // Carregar camadas do backend
            fetch('/api/camadas')
                .then(resposta => resposta.json())
                .then(dados => {
                    if (dados.features && dados.features.length > 0) {
                        // Criar camada gráfica para as features
                        const camadaGrafica = new GraphicsLayer({
                            title: "Camadas Geoespaciais"
                        });

                        // Adicionar cada feature à camada gráfica
                        dados.features.forEach((feature) => {
                            const grafico = new Graphic({
                                geometry: feature.geometry,
                                attributes: feature.properties,
                                popupTemplate: new PopupTemplate({
                                    title: "{nome}",
                                    content: `
                                        <div style="padding: 5px;">
                                            <p><strong>ID:</strong> {id}</p>
                                            <p><strong>Nome:</strong> {nome}</p>
                                        </div>
                                    `
                                })
                            });
                            camadaGrafica.add(grafico);
                        });

                        mapa.add(camadaGrafica);

                        // Ajustar extensão para mostrar todas as camadas
                        visualizacaoMapa.whenLayerView(camadaGrafica).then(function() {
                            visualizacaoMapa.goTo(camadaGrafica.fullExtent);
                        });
                    } else {
                        console.log('Nenhuma camada encontrada no banco de dados');
                    }
                })
                .catch(erro => {
                    console.error('Erro ao carregar camadas:', erro);
                })
                .finally(() => {
                    // Esconder loader
                    document.getElementById('carregador-mapa').classList.remove('ativo');
                });

            // Adicionar widget de legenda
            const legenda = new Legend({
                view: visualizacaoMapa
            });

            // Adicionar expansão da legenda
            const expansaoLegenda = new Expand({
                view: visualizacaoMapa,
                content: legenda,
                expandIconClass: "esri-icon-layer-list",
                expanded: false
            });

            visualizacaoMapa.ui.add(expansaoLegenda, "top-right");
        });
    </script>
</body>
</html>

