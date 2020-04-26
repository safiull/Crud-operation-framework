<?php

class crudOperation{
	private $data;
	private $table;
	private $insertBtn;
	private $editBtn;
	private $editDesign;
	private $editUrl;
	private $deleteBtn;
	private $deleteDesign;
	private $deleteUrl;

	public function setData($file){
		$file = file_get_contents("country.json");
		$this->data = json_decode($file, true);
		return $this;
	}

	public function insertBtn($url="#",$label=" Add New ",$css_classes="btn btn-success"){
		$this->insertBtn = "<a href=\"url\" class=\"$css_classes\">".$label."</a>";
		return $this;
	}
	public function editBtn($label="<i class=\"fa fa-edit\"></i>",$url="edit.php",$css_classes="btn btn-warning"){
		$this->editBtn = $label;
		$this->editUrl = $url;
		$this->editDesign = $css_classes;
		return $this;
	}
	public function deleteBtn($label="<i class=\"fa fa-trash\"></i>",$url="delete.php",$css_classes="btn btn-danger ml-2"){
		$this->deleteBtn = $label;
		$this->deleteUrl = $url;
		$this->deleteDesign = $css_classes;
		return $this;
	}
	public function tableCreation($css_classes="table table-hover table-dark"){
		$this->table = "<table class='$css_classes'>";
			$this->table.="<thead>";
				$this->table.="<tr>";
				// ami jani na je koyta row hobe er jonno amake total ta use korte hobe jate shob row gula print hoye jay,
					$total = 0;
					foreach($this->data[0] as $key => $value) {
						$total++;
						$this->table.= "<th>".ucfirst($key)."</th>";
					}
					// jodi edit and delete button ke call kore then action ta asbe
						if (isset($this->editBtn) || isset($this->deleteBtn)){
							$this->table.="<th>Action</th>";
						}
				$this->table.="</tr>";
			$this->table.="</thead>";

			$this->table.="<tbody>";
				foreach ($this->data as $row) {
					$this->table.="<tr>";
						foreach ($row as $key => $value) {
							$this->table.="<td>$value</td>";
						}
						// jodi edit or delete button ke call kore then td start hobe
						if (isset($this->editBtn) || isset($this->deleteBtn)){
							$this->table.="<td>";
						
							if (isset($this->editBtn)) {
								$url=$this->editUrl;
								$editBtnDesign=$this->editDesign;
								$this->table.="<a class=\"$editBtnDesign\" href=\"$url?id=$row[id]\">".$this->editBtn."</a>";
							}

							if (isset($this->deleteBtn)) {
								$url=$this->deleteUrl;
								$deleteDesign=$this->deleteDesign;
								$this->table.="<a class=\"$deleteDesign\" href=\"$url?id=$row[id]\">".$this->deleteBtn."</a>";
							}
							
						$this->table.="</td>";
					}
						$this->table.="</tr>";
					}
					// sobar last a 1ta row create hobe, colspan diye column count kora hoy,
					if(isset($this->insertBtn)){
						$this->table.= "<tr>";
							$this->table.= "<td style=\"text-align:center\" colspan=\"$total\">".$this->insertBtn."</td>";
						$this->table.= "</tr>";
					}
			$this->table.="</tbody>";
		$this->table.="</table>";

		return $this->table;
	}
}

$obj = new crudOperation();