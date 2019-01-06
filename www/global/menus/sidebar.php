<div class="col-xs-7 col-sm-3 col-md-2 sidebar" id="sidebar">
	<div class="col-xs-12 no-padding">
		<?php 
			echo $LOGO_CAMINHO;
		?>

		<div class="nav-sidebar">
			<!-- CADASTROS -->
			<div class="dropdown">
				<button class="btn dropdown-toggle" type="button" data-toggle="dropdown">
					Cadastros 
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<?php
						echo 
						"<li><a href='$participantes'> Participantes </a></li>" .
						"<li><a href='$professores'>   Professores   </a></li>" .
						"<li><a href='$turmas'> 	   Turmas		 </a></li>" .
						"<li><a href='$cursos'> 	   Cursos        </a></li>" .
						"<li><a href='$usuarios'> 	   Usuários      </a></li>";
					?>
				</ul>
			</div>

			<!-- MATRICULAS -->
			<div>
				<a class="btn" href=<?php echo $matriculas ?>>
					Matriculas 
				</a>
			</div>

			<!-- CERTIFICADOS -->
			<div>
				<a class="btn" href=<?php echo $certificados ?>>
					Certificados 
				</a>
			</div>
		</div>

	</div>

	<!-- LOGOUT -->
	<div>
		<button id="btn_logout" class="btn btn-logout"> 
			<span class="glyphicon glyphicon-off"></span>
		</button>
	</div>
</div>