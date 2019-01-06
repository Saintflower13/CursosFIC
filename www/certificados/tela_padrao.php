<?php 
	$select_semestre 		      = '"p_participante_semestre"';
	$input_ano 				      = '"p_participante_ano"';
	$select_curso 			      = '"p_participante_curso"';
	$select_turma			      = '"p_participante_turma"';
	$input_destinatario           = '"p_participante"';
	$placeholder_destinatario     = '"Participante(s)"';
	$botao_filtrar   		      = '"p_participante_filtrar"';
	$titulo_lista_com_email       = '"Participantes matriculados:"';
	$mostrar_sem_email 		      = '"Mostrar participantes sem email cadastrado"';
	$table_resultado_matriculados = '"p_participante_matriculados"';
	$titulo_lista_sem_email       = '"Participantes sem email cadastrado:"';
	$table_resultado_sem_email    = '"p_participante_sem_email"';
	$input_enviar_email		      = '"p_participante_enviar"';
	$input_imprimir_email	      = '"p_participante_imprimir"';
	$input_resetar			      = '"p_participante_resetar"';

	include "tela_padrao.php";
?> 

<h3> Enviar Certificados: </h3>

<form>
	<div class="row">
		<div class="form-group col-xs-12 col-sm-2">
			<select id=<?php echo $select_semestre ?> class="form-control">
				<option value="sem"> Semestre </option>
				<option value="1">   1        </option>
				<option value="2">   2	  	   </option>
			</select>
		</div>

		<div class="form-group col-xs-12 col-sm-2">
			<input type="text" id=<?php echo $input_ano ?> class="form-control" placeholder="Ano" autocomplete="off">
		</div>

		<div class="form-group col-xs-12 col-sm-3">
			<select id=<?php echo $select_curso ?> class="form-control">
				<option value="curso"> Curso </option>
			</select>
		</div>

		<div class="form-group col-xs-12 col-sm-2">
			<select id=<?php echo $select_turma ?> class="form-control">
				<option value="turma"> Turma </option>
			</select>
		</div>

		<div class="form-group col-xs-12 col-sm-2">
			<input type="text" id=<?php echo $input_destinatario ?> class="form-control" placeholder=<?php echo $placeholder_destinatario ?> autocomplete="off">
		</div>

		<div class="form-group col-xs-12 col-sm-1">
			<button id=<?php echo $botao_filtrar ?> class="form-control btn btn-success">
				<span class="glyphicon glyphicon-search"></span>
			</button>
		</div>
	</div>
</form>

<div class="row">
	<div class="col-xs-12">
		<div class="col-xs-12 col-sm-8 container-interior-padrao">
			<h4 style="display: inline;"> <?php echo $titulo_lista_com_email ?> </h4>
			<span>
				<label style="display: inline; font-size: 0.7em; color: gray;"><input type="checkbox" value="1">
				<?php echo $mostrar_sem_email ?> </label> 
			</span>

			<table id=<?php echo $table_resultado_matriculados ?> class="table tabela-certificados table-striped table-hover table-responsive table-condensed">
				<tr>
					<td class="checkbox col-xs-12">
						<label>
							<input type="checkbox" value="1"> 001 - Emanuelle Christine de Santana Flôr - manu714074@gmail.com 
						</label>
					</td>
				</tr>
			</table>
		</div>

		<div class="col-xs-12 col-sm-4 container-interior-padrao">
			<h4 class="color-darkred"> <?php echo $titulo_lista_sem_email ?> </h4>

			<table id=<?php echo $table_resultado_sem_email ?> class="table tabela-certificados table-striped table-hover table-responsive table-condensed fonte-menor">
				<tr><td class="col-xs-12">
					001 - Emanuelle Christine de Santana Flôr  
				</tr></td>
			</table>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
	<!--
		<div class="col-xs-12 panel-mensagem">
			Emails enviados com sucesso
		</div> 
	-->
	</div>
</div>

<div class="row">
	<div class="form-buttons col-xs-12">
		<div class="form-group">
			<input type="submit" id=<?php echo $input_enviar_email ?> class="btn btn-success col-xs-12 col-sm-4 col-md-3" value="Enviar Certificados">
			<input type="submit" id=<?php echo $input_imprimir_email ?> class="btn btn-success col-xs-12 col-sm-4 col-md-3 margin-responsiva" value="Imprimir Certificados">
			<input type="reset" id=<?php echo $input_resetar ?> class="btn btn-danger col-xs-12 col-sm-2 col-md-2" value="Limpar">
		</div>
	</div>
</div>