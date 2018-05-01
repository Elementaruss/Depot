<?php 
          echo validation_errors();
          echo form_open('visiteur/unerecherche');
          echo form_input('recherche', set_value('rechercher'));
           
          echo form_submit('submit', 'Rechercher');
          echo form_close(); ?>