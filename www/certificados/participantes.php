<!--
	A TELA É PRIMARIAMENTE DIVIDIDA EM DUAS, MOSTRANDO OS ALUNOS QUE POSSUEM EMAIL CADASTRADO E OS QUE NÃO.
	QUANDO O CHECKBOX NÃO ESTIVER SELECIONADO, É MUDADO POR MEIO DE JQUERY O DISPLAY DA DIV QUE POSSUI A INFORMAÇÃO
	DOS PARTICIPANTES SEM EMAIL PARA "NONE" E É ALTERADO TAMBÉM A WIDTH DA DIV DOS PARTICIPANTES COM EMAIL PARA OCUPAR
	O ESPAÇO RESTANTE. ESSA INFORMAÇÃO É GRAVADA NO BANCO DE DADOS.

	A PRINCÍPIO, O SELECT DE CURSO SERÁ CARREGADO COM OS PRIMEIROS 100 CURSOS CADASTRADOS POR ORDEM DESCENDENTE DE CADASTRO.
	PARA TER ACESSO A CURSOS MAIS ANTIGOS, SERÁ PRECISO FILTRAR PELOS CAMPOS DE SEMESTRE E/OU ANO.

	O SELECT DE TURMA APENAS SERÁ CARREGADO COM O CURSO SELECIONADO E SEGUE O MESMO ESQUEMA DE FILTRO DO CURSO.

	A RESPEITO DA PESQUISA:
	QUANDO FOR INFORMADO APENAS ID(S) DO PARTICIPANTE(S), OS ITENS APARECERÃO COM OS SEGUINTES DADOS: ID, NOME, EMAIL, CURSO, SEM/ANO.
	CASO CONTRÁRIO, APARECERÁ APENAS: ID, NOME, EMAIL. 
-->
<h3> Enviar Certificados: </h3>

<div class="row">
	<div class="form-group col-xs-12 col-sm-2 col-md-1 no-padding-right">
		<button id="btn_limpar_filtros_participantes" class="btn btn-danger form-control">
			<span class="glyphicon glyphicon-remove"></span>
		</button>
	</div>

	<div class="form-group col-xs-12 col-sm-5 col-md-2 no-padding-right participante-header-filtro">
		<select id="p_participante_semestre" class="form-control">
			<option id="sem_inicial" value="0"> Semestre </option>
			<option value="1">        			1        </option>
			<option value="2"> 		  			2    	 </option>
		</select>
	</div>

	<div class="form-group col-xs-12 col-sm-5 col-md-2 no-padding-right participante-header-filtro">
		<input type="text" id="p_participante_ano" class="form-control apenas-inteiro" placeholder="Ano" autocomplete="off">
	</div>

	<div class="form-group col-xs-12 col-sm-5 col-md-4 no-padding-right participante-header-filtro">
		<select id="p_participante_curso" class="form-control">
			<option id="curso_inicial" value="0"> Curso </option>
		</select>
	</div>

	<div class="form-group col-xs-12 col-sm-5 col-md-2 no-padding-right participante-header-filtro">
		<select id="p_participante_turma" class="form-control">
			<option id="turma_inicial" value="0"> Turma </option>
		</select>
	</div>

	<div class="form-group col-xs-12 col-sm-2 no-padding-right" style="display: none;">
		<input type="text" id="p_participante" class="form-control" placeholder="Participante" autocomplete="off">
	</div>

	<div class="form-group col-xs-12 col-sm-2 col-md-1 no-padding-right participante-header-filtro">
		<button id="selecionar_turma" class="btn btn-success form-control" >
			<span class="glyphicon glyphicon-ok"></span>
		</button>
	</div>

	<div class="form-group col-xs-12 col-sm-10 col-md-11 participantes-header-turma" style="display: none;">
		Turma: <span id="turma_selecionada"> [CURSO] 0001 - DESCRIÇÃO, 1SEM/2018, 13:00, SEG-TER-QUA  </span>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div id="div_participantes_matriculados" class="col-xs-12 col-sm-8 container-interior-padrao">
			<h4 class="titulo"> Participantes matriculados: </h4>
			<span class="col-xs-12 subtitulo-group">
				<label class="subtitulo col-xs-12 col-sm-4">
					<input id="selecionar_todos_participantes" type="checkbox"> Selecionar todos
				</label> 

				<label class="subtitulo col-xs-12 col-sm-8">
					<input id="mostrar_participantes_sem_email" type="checkbox" value="1" checked> Mostrar participantes sem email cadastrado 
				</label> 
			</span>
			
			<table id="participantes_matriculados" class="table tabela-certificados table-striped table-hover table-responsive table-condensed">
				<tr class="tabela-nenhum-registro">
					<td class="tabela-resultados-mensagem">
						Nenhum registro para exibir, no momento :) 
					</td>
				</tr>
			</table>
		</div>

		<div id="div_participantes_sem_email" class="col-xs-12 col-sm-4 container-interior-padrao">
			<h4 class="titulo-darkred"> Participantes sem email cadastrado: </h4>

			<table id="participantes_sem_email" class="table tabela-certificados table-striped table-hover table-responsive table-condensed fonte-menor">
				<tr class="tabela-nenhum-registro">
					<td class="tabela-resultados-mensagem">
						Nenhum registro para exibir, no momento :) 
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>

<div class="row">
	<div class="form-buttons col-xs-12">
		<div class="form-group">
			<input type="button" id="btn_participante_enviar_certificados" class="btn btn-success col-xs-12 col-sm-5 col-md-4" value="Enviar Certificados">
			<input type="button" id="btn_participante_imprimir_certificados" class="btn btn-success col-xs-12 col-sm-5 col-md-4 margin-responsiva" value="Imprimir Certificados">
		</div>
	</div>
</div>









