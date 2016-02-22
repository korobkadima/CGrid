<h1>Grid</h1>
DataGrid is a simple presenter widget for database queries
<br/>
Display results in a HTML Table (defining each column)<br/>
Define each column, row, format column.<br/>

<h2>Example</h2>

		
		require_once('grid.php'); 
		
		#function for format
		function formatid($id,$arr)
		{
			return 'ID:' . $id;
		}
	
		$g = new grid();
		
		#set tablename<br/>
		$g->set_table('tableame');
		
		#set primary key
		$g->set_pk('id');
		
		#set limit
		$g->set_limit(5);	
				
		#set columns of tale for select		
		$g->set_select(array('id','name','date','text'));
		
		#set name of columns
		$g->set_name('id','ID');
		$g->set_name('date','Date');
		$g->set_name('name','Name');
		$g->set_name('xxx','some fild');
		
		#set buttons<br/>
		$g->set_button('/reg/','Reg');
		$g->set_button('/del/','Del');
		$g->set_button_function('mybutton','My button');
		
		#set format for column id
		$g->set_format('id','formatid');
		
		#print result
		$g->print_table();<br/>