<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Planejar & Programar — PP</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="layout">
  <aside class="sidebar">
    <div class="brandbox">
      <!-- Added icon image instead of text logo -->
      <div class="brandlogo">
        <img src="public/1icone.png" alt="PP Logo" style="width: 48px; height: 48px; object-fit: contain;">
      </div>
      <div class="brandtxt">
        <div class="t">Planejar & Programar</div>
        <div class="s">MS Project-like</div>
      </div>
    </div>
    <div class="menu">
      <button id="mHome" class="active">Início</button>
      <button id="mProjects">Projetos</button>
      <button id="mSchedule">Cronograma</button>
      <button id="mWO">Ordens de Serviço</button>
      <button id="mS">Curva S</button>
      <button id="mMaterials">Materiais</button>
      <button id="mAssets">Ativos/Equipamentos</button>
      <button id="mReports">Relatórios</button>
      <button id="mData">Importar/Exportar</button>

      <a class="linkbtn" data-ext="site" href="https://planejareprogramar.com.br/" target="_blank" rel="noopener">Voltar ao site</a>
      <a class="linkbtn" data-ext="blog" href="https://planejareprogramar.com.br/blog" target="_blank" rel="noopener">Ir ao blog</a>
    </div>
  </aside>
  <main>
    <header class="topbar">
      <div class="brand">
        <!-- Added icon image in header -->
        <span class="logo">
          <img src="public/1icone.png" alt="PP" style="width: 40px; height: 40px; object-fit: contain;">
        </span>
        <div class="titles">
          <h1>Planejar & Programar</h1>
          <p>Baselines · Curva S · Índices</p>
        </div>
      </div>
    </header>

    <!-- Removed login/register, simplified home section -->
    <div id="homeSection" class="section">
      <div class="hero">
        <div>
          <h2>Bem-vindo à sua central de projetos</h2>
          <p class="muted">Monte cronogramas, defina baselines e acompanhe SPI/CPI.</p>
          <div class="row" style="margin-top:12px">
            <a class="linkbtn" data-ext="site" href="https://planejareprogramar.com.br/" target="_blank" rel="noopener">Voltar ao site</a>
            <a class="linkbtn" data-ext="blog" href="https://planejareprogramar.com.br/blog" target="_blank" rel="noopener">Ir ao blog</a>
          </div>
        </div>
      </div>

      <div class="grid">
        <div class="card">
          <h3>Como começar</h3>
          <ol>
            <li>Cadastre um projeto na aba "Projetos".</li>
            <li>Monte o cronograma com tarefas e dependências (FS/SS/FF/SF + lag).</li>
            <li>Salve baseline e gere a Curva S.</li>
            <li>Use "Importar/Exportar" para salvar seus dados em arquivo .pp</li>
          </ol>
        </div>
        <div class="card">
          <h3>Seus Dados</h3>
          <p class="muted">Todos os dados são salvos localmente no seu navegador.</p>
          <p class="muted">Use a aba "Importar/Exportar" para fazer backup dos seus projetos em arquivo .pp</p>
          <div class="row" style="margin-top:12px">
            <button id="btnQuickExport" class="ghost">Exportar Agora</button>
          </div>
        </div>
      </div>
    </div>

    <div id="projectsSection" class="section hidden">
      <div class="card headrow">
        <h2>Projetos</h2>
        <div class="row">
          <button id="btnNewProject">+ Novo Projeto</button>
        </div>
      </div>
      <div class="card">
        <table id="projectsTable" class="table">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Código</th>
              <th>Período</th>
              <th>Status</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>

    <div id="scheduleSection" class="section hidden">
      <div class="card headrow">
        <h2>Cronograma</h2>
        <div class="row">
          <label>Projeto<select id="selProjectSchedule"></select></label>
          <button id="btnNewTask">+ Nova Tarefa</button>
          <label class="switch">
            <input type="checkbox" id="chkAutoSchedule" checked> 
            <span>Auto-Agendar</span>
          </label>
          <button id="btnBaseline" class="ghost">Salvar Baseline…</button>
          <label>Zoom<input type="range" id="zoom" min="5" max="50" value="20"/></label>
        </div>
      </div>
      <!-- Replaced table with spreadsheet container -->
      <div class="card">
        <div id="scheduleTableContainer" style="overflow-x: auto; max-height: 500px; overflow-y: auto;"></div>
      </div>
      <div class="card ganttbox">
        <h3 style="margin-bottom: 12px;">Gráfico de Gantt</h3>
        <svg id="gantt" width="100%" height="360"></svg>
      </div>
      <div id="warnCycle" class="alert hidden">⚠️ Dependências com ciclo detectado — ajuste as predecessoras.</div>
    </div>

    <div id="sSection" class="section hidden">
      <div class="card headrow">
        <h2>Curva S & Índices</h2>
        <div class="row">
          <label>Projeto<select id="selProjectS"></select></label>
          <label>Baseline<select id="selBaselineA"></select></label>
          <button id="btnRefreshS">Atualizar</button>
        </div>
      </div>
      
      <!-- Added filter options for S-curve metrics -->
      <div class="card" style="background: #f8fafc; padding: 16px; margin-bottom: 16px;">
        <h3 style="margin-bottom: 12px; font-size: 14px; font-weight: 600;">Filtros de Visualização</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
          <div>
            <strong style="font-size: 13px; color: #475569;">Progresso Físico</strong>
            <div style="display: flex; flex-direction: column; gap: 6px; margin-top: 6px;">
              <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; cursor: pointer;">
                <input type="checkbox" id="filterPlannedProgress" checked onchange="drawSCurve()">
                <span>Planejado</span>
              </label>
              <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; cursor: pointer;">
                <input type="checkbox" id="filterActualProgress" checked onchange="drawSCurve()">
                <span>Real</span>
              </label>
              <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; cursor: pointer;">
                <input type="checkbox" id="filterWeightedProgress" onchange="drawSCurve()">
                <span>Ponderado por Peso</span>
              </label>
            </div>
          </div>
          
          <div>
            <strong style="font-size: 13px; color: #475569;">Custos</strong>
            <div style="display: flex; flex-direction: column; gap: 6px; margin-top: 6px;">
              <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; cursor: pointer;">
                <input type="checkbox" id="filterPlannedCost" onchange="drawSCurve()">
                <span>Custo Planejado</span>
              </label>
              <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; cursor: pointer;">
                <input type="checkbox" id="filterActualCost" onchange="drawSCurve()">
                <span>Custo Real</span>
              </label>
            </div>
          </div>
          
          <div>
            <strong style="font-size: 13px; color: #475569;">Horas</strong>
            <div style="display: flex; flex-direction: column; gap: 6px; margin-top: 6px;">
              <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; cursor: pointer;">
                <input type="checkbox" id="filterPlannedHours" onchange="drawSCurve()">
                <span>Horas Planejadas</span>
              </label>
              <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; cursor: pointer;">
                <input type="checkbox" id="filterActualHours" onchange="drawSCurve()">
                <span>Horas Reais</span>
              </label>
            </div>
          </div>
        </div>
        <p style="margin-top: 12px; font-size: 12px; color: #64748b;">
          💡 Selecione as métricas que deseja visualizar na Curva S. O progresso ponderado considera o peso de cada tarefa.
        </p>
      </div>
      
      <div class="card ganttbox">
        <svg id="sCurve" width="100%" height="360"></svg>
      </div>
      <div id="kpis" class="row"></div>
    </div>

    <div id="reportsSection" class="section hidden">
      <div class="card headrow">
        <h2>Relatórios Avançados</h2>
        <div class="row">
          <label>Projeto <select id="selProjectReports"></select></label>
          <button id="btnCreateCustomReport">+ Relatório Personalizado</button>
          <button id="btnExportReportPDF" class="ghost">Exportar PDF</button>
        </div>
      </div>
      
      <!-- Report type selector -->
      <div class="card" style="background: #f8fafc; padding: 16px;">
        <h3 style="margin-bottom: 12px; font-size: 14px; font-weight: 600;">Tipo de Relatório</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
          <button id="btnReportOverview" class="report-type-btn active" onclick="showReportType('overview')">
            📊 Visão Geral
          </button>
          <button id="btnReportCost" class="report-type-btn" onclick="showReportType('cost')">
            💰 Análise de Custos
          </button>
          <button id="btnReportDelayed" class="report-type-btn" onclick="showReportType('delayed')">
            ⏰ Tarefas Atrasadas
          </button>
          <button id="btnReportTrend" class="report-type-btn" onclick="showReportType('trend')">
            📈 Linha de Tendência
          </button>
          <button id="btnReportPerformance" class="report-type-btn" onclick="showReportType('performance')">
            🎯 Desempenho (EVM)
          </button>
          <button id="btnReportCustom" class="report-type-btn" onclick="showReportType('custom')">
            ⚙️ Personalizado
          </button>
        </div>
      </div>
      
      <!-- Overview Report -->
      <div id="reportOverview" class="report-content">
        <div class="card">
          <h3>Resumo Executivo do Projeto</h3>
          <div id="overviewMetrics" class="grid" style="margin-top: 16px;"></div>
        </div>
        
        <div class="card">
          <h3>Distribuição de Tarefas por Status</h3>
          <canvas id="chartTaskStatus" width="100%" height="300"></canvas>
        </div>
        
        <div class="grid">
          <div class="card">
            <h3>Progresso por Fase</h3>
            <canvas id="chartPhaseProgress" width="100%" height="250"></canvas>
          </div>
          <div class="card">
            <h3>Alocação de Recursos</h3>
            <canvas id="chartResourceAllocation" width="100%" height="250"></canvas>
          </div>
        </div>
      </div>
      
      <!-- Cost Report -->
      <div id="reportCost" class="report-content hidden">
        <div class="card">
          <h3>Análise de Custos</h3>
          <div id="costMetrics" class="grid" style="margin-top: 16px;"></div>
        </div>
        
        <div class="card">
          <h3>Evolução de Custos ao Longo do Tempo</h3>
          <canvas id="chartCostTrend" width="100%" height="300"></canvas>
        </div>
        
        <div class="grid">
          <div class="card">
            <h3>Custos por Categoria</h3>
            <canvas id="chartCostByCategory" width="100%" height="250"></canvas>
          </div>
          <div class="card">
            <h3>Desvio de Custos</h3>
            <canvas id="chartCostVariance" width="100%" height="250"></canvas>
          </div>
        </div>
        
        <div class="card">
          <h3>Detalhamento de Custos por Tarefa</h3>
          <table id="costDetailsTable" class="table">
            <thead>
              <tr>
                <th>Tarefa</th>
                <th>Custo Planejado</th>
                <th>Custo Real</th>
                <th>Desvio</th>
                <th>% Desvio</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
      
      <!-- Delayed Tasks Report -->
      <div id="reportDelayed" class="report-content hidden">
        <div class="card">
          <h3>Tarefas Atrasadas - Análise Crítica</h3>
          <div id="delayedMetrics" class="grid" style="margin-top: 16px;"></div>
        </div>
        
        <div class="card">
          <h3>Impacto dos Atrasos no Cronograma</h3>
          <canvas id="chartDelayImpact" width="100%" height="300"></canvas>
        </div>
        
        <div class="card">
          <h3>Lista de Tarefas Atrasadas</h3>
          <table id="delayedTasksTable" class="table">
            <thead>
              <tr>
                <th>WBS</th>
                <th>Tarefa</th>
                <th>Responsável</th>
                <th>Data Prevista</th>
                <th>Dias de Atraso</th>
                <th>Progresso</th>
                <th>Impacto</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
      
      <!-- Trend Report -->
      <div id="reportTrend" class="report-content hidden">
        <div class="card">
          <h3>Análise de Tendências e Previsões</h3>
          <div id="trendMetrics" class="grid" style="margin-top: 16px;"></div>
        </div>
        
        <div class="card">
          <h3>Linha de Tendência - Progresso Projetado</h3>
          <canvas id="chartProgressTrend" width="100%" height="350"></canvas>
        </div>
        
        <div class="grid">
          <div class="card">
            <h3>Tendência de Custos</h3>
            <canvas id="chartCostProjection" width="100%" height="250"></canvas>
          </div>
          <div class="card">
            <h3>Velocidade de Execução</h3>
            <canvas id="chartVelocity" width="100%" height="250"></canvas>
          </div>
        </div>
        
        <div class="card">
          <h3>Previsões Baseadas em Tendências</h3>
          <div id="forecastDetails" style="padding: 16px; background: #f8fafc; border-radius: 8px;"></div>
        </div>
      </div>
      
      <!-- Performance (EVM) Report -->
      <div id="reportPerformance" class="report-content hidden">
        <div class="card">
          <h3>Análise de Valor Agregado (EVM)</h3>
          <div id="evmMetrics" class="grid" style="margin-top: 16px;"></div>
        </div>
        
        <div class="card">
          <h3>Curva de Valor Agregado</h3>
          <canvas id="chartEVM" width="100%" height="350"></canvas>
        </div>
        
        <div class="grid">
          <div class="card">
            <h3>Índices de Desempenho</h3>
            <canvas id="chartPerformanceIndexes" width="100%" height="250"></canvas>
          </div>
          <div class="card">
            <h3>Variações (CV e SV)</h3>
            <canvas id="chartVariances" width="100%" height="250"></canvas>
          </div>
        </div>
      </div>
      
      <!-- Custom Report -->
      <div id="reportCustom" class="report-content hidden">
        <div class="card">
          <h3>Criar Relatório Personalizado</h3>
          <div style="display: grid; grid-template-columns: 250px 1fr; gap: 24px; margin-top: 16px;">
            <!-- Filters sidebar -->
            <div style="background: #f8fafc; padding: 16px; border-radius: 8px;">
              <h4 style="margin-bottom: 12px;">Filtros</h4>
              
              <label style="display: block; margin-bottom: 12px;">
                <strong style="font-size: 13px;">Período</strong>
                <input type="date" id="customReportStartDate" style="width: 100%; margin-top: 4px;">
                <input type="date" id="customReportEndDate" style="width: 100%; margin-top: 4px;">
              </label>
              
              <label style="display: block; margin-bottom: 12px;">
                <strong style="font-size: 13px;">Status</strong>
                <select id="customReportStatus" multiple style="width: 100%; margin-top: 4px; height: 80px;">
                  <option value="not-started">Não Iniciada</option>
                  <option value="in-progress">Em Andamento</option>
                  <option value="completed">Concluída</option>
                  <option value="delayed">Atrasada</option>
                </select>
              </label>
              
              <label style="display: block; margin-bottom: 12px;">
                <strong style="font-size: 13px;">Responsável</strong>
                <select id="customReportResponsible" style="width: 100%; margin-top: 4px;">
                  <option value="">Todos</option>
                </select>
              </label>
              
              <h4 style="margin: 16px 0 12px;">Métricas</h4>
              <div style="display: flex; flex-direction: column; gap: 6px;">
                <label style="display: flex; align-items: center; gap: 6px; font-size: 13px;">
                  <input type="checkbox" id="metricProgress" checked> Progresso
                </label>
                <label style="display: flex; align-items: center; gap: 6px; font-size: 13px;">
                  <input type="checkbox" id="metricCost" checked> Custos
                </label>
                <label style="display: flex; align-items: center; gap: 6px; font-size: 13px;">
                  <input type="checkbox" id="metricHours" checked> Horas
                </label>
                <label style="display: flex; align-items: center; gap: 6px; font-size: 13px;">
                  <input type="checkbox" id="metricDelay"> Atrasos
                </label>
              </div>
              
              <h4 style="margin: 16px 0 12px;">Tipo de Gráfico</h4>
              <select id="customChartType" style="width: 100%;">
                <option value="line">Linha</option>
                <option value="bar">Barra</option>
                <option value="pie">Pizza</option>
                <option value="doughnut">Rosca</option>
                <option value="radar">Radar</option>
                <option value="area">Área</option>
              </select>
              
              <button id="btnGenerateCustomReport" style="width: 100%; margin-top: 16px;">
                Gerar Relatório
              </button>
            </div>
            
            <!-- Report display area -->
            <div>
              <div id="customReportResults">
                <div style="text-align: center; padding: 48px; color: #94a3b8;">
                  <p>Configure os filtros e clique em "Gerar Relatório"</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="woSection" class="section hidden">
      <div class="card headrow">
        <h2>Ordens de Serviço</h2>
        <div class="row">
          <label>Projeto<select id="selProjectWO"></select></label>
          <button id="btnNewWO">+ Nova OS</button>
        </div>
      </div>
      <div class="card">
        <!-- Enhanced work orders table with indicators -->
        <table id="woTable" class="table">
          <thead>
            <tr>
              <th style="width: 40px;">Status</th>
              <th style="width: 80px;">#</th>
              <th>Título</th>
              <th style="width: 100px;">Prioridade</th>
              <th style="width: 120px;">Status</th>
              <th style="width: 150px;">Responsável</th>
              <th style="width: 200px;">Datas</th>
              <th style="width: 120px;">Horas</th>
              <th style="width: 150px;">Progresso</th>
              <th style="width: 150px;">Tarefa</th>
              <th style="width: 100px;">Ações</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>

    <!-- Added Materials Control section -->
    <div id="materialsSection" class="section hidden">
      <div class="card headrow">
        <h2>Controle de Materiais</h2>
        <div class="row">
          <label>Projeto<select id="selProjectMaterials"></select></label>
          <button id="btnNewMaterial">+ Novo Material</button>
        </div>
      </div>
      <div class="card">
        <table id="materialsTable" class="table">
          <thead>
            <tr>
              <th style="width: 80px;">Código</th>
              <th>Nome</th>
              <th style="width: 150px;">Categoria</th>
              <th style="width: 80px;">Unidade</th>
              <th style="width: 100px;">Custo Unit.</th>
              <th style="width: 100px;">Qtd. Disp.</th>
              <th style="width: 100px;">Estoque Mín.</th>
              <th style="width: 80px;">Status</th>
              <th style="width: 150px;">Fornecedor</th>
              <th style="width: 100px;">Ações</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>

    <!-- Added Asset Management section -->
    <div id="assetsSection" class="section hidden">
      <div class="card headrow">
        <h2>Gerenciamento de Ativos e Equipamentos</h2>
        <div class="row">
          <label>Projeto<select id="selProjectAssets"></select></label>
          <button id="btnNewAsset">+ Novo Ativo</button>
          <button id="btnAssetLog" class="ghost">Registrar Uso</button>
        </div>
      </div>
      
      <!-- Asset metrics dashboard -->
      <div class="grid" style="margin-bottom: 16px;">
        <div class="card" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white;">
          <h3 style="color: white; margin-bottom: 8px;">Total de Ativos</h3>
          <div style="font-size: 32px; font-weight: 800;" id="totalAssets">0</div>
        </div>
        <div class="card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
          <h3 style="color: white; margin-bottom: 8px;">Em Operação</h3>
          <div style="font-size: 32px; font-weight: 800;" id="assetsRunning">0</div>
        </div>
        <div class="card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white;">
          <h3 style="color: white; margin-bottom: 8px;">Manutenção Urgente</h3>
          <div style="font-size: 32px; font-weight: 800;" id="assetsMaintenanceUrgent">0</div>
        </div>
        <div class="card" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: white;">
          <h3 style="color: white; margin-bottom: 8px;">Taxa de Utilização</h3>
          <div style="font-size: 32px; font-weight: 800;" id="avgUtilization">0%</div>
        </div>
      </div>
      
      <div class="card">
        <table id="assetsTable" class="table">
          <thead>
            <tr>
              <th style="width: 80px;">Código</th>
              <th>Nome</th>
              <th style="width: 120px;">Tipo</th>
              <th style="width: 100px;">Status</th>
              <th style="width: 120px;">Localização</th>
              <th style="width: 100px;">Horas Uso</th>
              <th style="width: 100px;">Tempo Parado</th>
              <th style="width: 100px;">Utilização</th>
              <th style="width: 150px;">Próx. Manutenção</th>
              <th style="width: 100px;">Ações</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>

    <!-- Enhanced import/export section -->
    <div id="dataSection" class="section hidden">
      <div class="card">
        <h2>Importar / Exportar Dados</h2>
        <p class="muted">Salve todos os seus projetos, tarefas, ordens de serviço e baselines em um arquivo .pp</p>
        <div class="row" style="margin-top:16px">
          <button id="btnExport">Exportar para arquivo .pp</button>
          <label class="filelabel">
            Importar arquivo .pp
            <input id="fileImport" type="file" accept=".pp,application/json">
          </label>
        </div>
        <hr style="border-color:var(--line); margin: 24px 0">
        <h3>Limpar Dados</h3>
        <p class="muted">Atenção: Esta ação não pode ser desfeita. Exporte seus dados antes de limpar.</p>
        <div class="row">
          <button id="btnClearData" class="danger">Limpar Todos os Dados</button>
        </div>
      </div>
    </div>

    <dialog id="projectDialog" class="dialogform"></dialog>
    <dialog id="taskDialog" class="dialogform"></dialog>
    <dialog id="woDialog" class="dialogform"></dialog>
    <dialog id="materialDialog" class="dialogform"></dialog>
    <dialog id="assetDialog" class="dialogform"></dialog>
    <dialog id="assetLogDialog" class="dialogform"></dialog>
    
    <!-- Added export dialog for custom filename, author, and company -->
    <dialog id="exportDialog" class="dialogform">
      <h2 style="margin-bottom: 16px;">Exportar Dados</h2>
      <form id="exportForm">
        <label>
          Nome do Arquivo
          <input type="text" id="exportFilename" placeholder="meu-projeto" required>
        </label>
        <label>
          Autor
          <input type="text" id="exportAuthor" placeholder="Seu nome">
        </label>
        <label>
          Empresa
          <input type="text" id="exportCompany" placeholder="Nome da empresa">
        </label>
        <div class="row" style="margin-top: 16px; justify-content: flex-end;">
          <button type="button" class="ghost" onclick="document.getElementById('exportDialog').close()">Cancelar</button>
          <button type="submit">Exportar</button>
        </div>
      </form>
    </dialog>
  </main>
</div>

<script src="assets/js/app.js?v=<?php echo time(); ?>"></script>
</body>
</html>
