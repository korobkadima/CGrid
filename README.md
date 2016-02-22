<h1>Grid</h1>
DataGrid is a simple presenter widget for database queries
<br/>
Display results in a HTML Table (defining each column)<br/>
Define each column, row, format columm<br/>
<br/><br/>
<h2>Example</h2>
<br/>
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/grid.php'); <br/>
	
		function formatid($id,$arr)<br/>
		{<br/>
			return 'ID:' . $id;<br/>
		}<br/>
	
		$g = new grid();<br/>
		
		#set tablename<br/>
		$g->set_table('tableame');<br/>
		
		#set primary key<br/>
		$g->set_pk('id');<br/>
		
		#set limit<br/>
		$g->set_limit(5);	<br/>
				
		#set columns of tale for select		<br/>
		$g->set_select(array('id','name','date','text'));<br/>
		
		#set name of columns<br/>
		$g->set_name('id','ID');<br/>
		$g->set_name('date','Дата');<br/>
		$g->set_name('name','Название');<br/>
		$g->set_name('xxx','Произвольное поле');<br/>
		
		#set buttons<br/>
		$g->set_button('/reg/','Редактировать');<br/>
		$g->set_button('/del/','Удалить');<br/>
		$g->set_button_function('mybutton','Моя кнопка');<br/>
		
		#set format for column id<br/>
		$g->set_format('id','formatid');<br/>
		
		#print result
		$g->print_table();<br/>