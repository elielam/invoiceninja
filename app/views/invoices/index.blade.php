@extends('header')

@section('content')

	{{ Former::open('invoices/action') }}
	<div style="display:none">{{ Former::text('action') }}</div>

	{{ DropdownButton::normal('Archive',
		  Navigation::links(
		    array(
		      array('Archive', "javascript:submitForm('archive')"),
		      array('Delete', "javascript:submitForm('delete')"),
		    )
		  )
		, array('id'=>'archive'))->split(); }}
	

	{{ Button::primary_link(URL::to('invoices/create'), 'New Invoice', array('class' => 'pull-right')) }}	
	
	
	{{ Datatable::table()		
    	->addColumn('checkbox', 'Invoice Number', 'Client', 'Total', 'Amount Due', 'Invoice Date', 'Due Date', 'Status')
    	->setUrl(route('api.invoices'))    	
    	->setOptions('sPaginationType', 'bootstrap')
    	->setOptions('bFilter', false)
    	->render('datatable') }}

    {{ Former::close() }}

    <script type="text/javascript">

	function submitForm(action) {
		$('#action').val(action);
		$('form').submit();		
	}

    </script>

@stop

@section('onReady')
	
	window.onDatatableReady = function() {
		$(':checkbox').click(function() {
			setArchiveEnabled();
		});	

		$('tbody tr').click(function() {
			$checkbox = $(this).closest('tr').find(':checkbox');
			var checked = $checkbox.prop('checked');
			$checkbox.prop('checked', !checked);
			setArchiveEnabled();
		});
	}	

	$('#archive > button').prop('disabled', true);
	$('#archive > button:first').click(function() {
		submitForm('archive');
	});

	$('#selectAll').click(function() {
		$(':checkbox').prop('checked', this.checked);
	});

	function setArchiveEnabled() {
		var checked = $('tbody :checkbox:checked').length > 0;
		$('#archive > button').prop('disabled', !checked);	
	}


@stop