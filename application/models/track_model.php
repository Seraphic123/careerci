<?php
class Track_model extends CI_Model {

	public function __construct()
	{
	}
	
	function go_track($data)
	{
		$this->db->insert('job_track', $data); 
	}
	function getJobcompetition($s_id,$j_name)
	{
		$sql = " SELECT DISTINCT s.`subject_name`, rs.year, rs.semester " . 
			" FROM `record_score` As rs, `subject` As s, `professional_ability` AS PA " . 
			" WHERE rs.`s_id` = '${s_id}' AND rs.`subject_id` = s.`subject_id` " .
			" AND PA.subject_name=s.subject_name " . 
//			" AND PA.`j_name`='程式設計師' ";
			" AND PA.`j_name`='${j_name}' ";
		$result = $this->db->query($sql);
		$data1 = $result->result_array();
		$takedCourse = $this->array_column($data1,'subject_name');
//		echo $sql;
		$sql2 = " SELECT subject_name FROM  `professional_ability` AS PA " .
			" WHERE PA.`j_name`='${j_name}' ";
		$result2 = $this->db->query($sql2);
		$data2 = $result2->result_array();
		$allCourse =  $this->array_column($data2,'subject_name');
//		echo $sql2;
//		print_r($allCourse);
		$needTakeCourse = array_diff($allCourse, $takedCourse);
		return array($allCourse, $takedCourse, $needTakeCourse);
	}
    function array_column($input = null, $columnKey = null, $indexKey = null)
    {
        // Using func_get_args() in order to check for proper number of
        // parameters and trigger errors exactly as the built-in array_column()
        // does in PHP 5.5.
        $argc = func_num_args();
        $params = func_get_args();

        if ($argc < 2) {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
            return null;
        }

        if (!is_array($params[0])) {
            trigger_error('array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given', E_USER_WARNING);
            return null;
        }

        if (!is_int($params[1])
            && !is_float($params[1])
            && !is_string($params[1])
            && $params[1] !== null
            && !(is_object($params[1]) && method_exists($params[1], '__toString'))
        ) {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
            return false;
        }

        if (isset($params[2])
            && !is_int($params[2])
            && !is_float($params[2])
            && !is_string($params[2])
            && !(is_object($params[2]) && method_exists($params[2], '__toString'))
        ) {
            trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
            return false;
        }

        $paramsInput = $params[0];
        $paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;

        $paramsIndexKey = null;
        if (isset($params[2])) {
            if (is_float($params[2]) || is_int($params[2])) {
                $paramsIndexKey = (int) $params[2];
            } else {
                $paramsIndexKey = (string) $params[2];
            }
        }

        $resultArray = array();

        foreach ($paramsInput as $row) {

            $key = $value = null;
            $keySet = $valueSet = false;

            if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
                $keySet = true;
                $key = (string) $row[$paramsIndexKey];
            }

            if ($paramsColumnKey === null) {
                $valueSet = true;
                $value = $row;
            } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
                $valueSet = true;
                $value = $row[$paramsColumnKey];
            }

            if ($valueSet) {
                if ($keySet) {
                    $resultArray[$key] = $value;
                } else {
                    $resultArray[] = $value;
                }
            }

        }

        return $resultArray;
    }	
	function del_track($t_id)
	{
		$this->db->delete('job_track', array('t_id' => $t_id)); 
		return 0;
	}	
	function select_track($s_id)
	{
		$query = $this->db->get_where('job_track',array('s_id'=>$s_id));
//		return $query->result();
		return $query->result_array();
/*
		$num=0;
		foreach ($query->result_array() as $row)
		{	
			$result[$num]=array(
				"j_name" => $row['j_name'],
				"j_url" => $row['j_url'],
				"j_cname" => $row['j_cname'],
				"j_address" => $row['j_address'],
				"j_date" => $row['j_date']
				);
			$num++;
		}
		$result1=json_encode($result);
		//print_r($result);
		
		
		echo $result1;
*/
	}
}

?>
