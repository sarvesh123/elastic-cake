<?php
App::uses('AppModel', 'Model');

App::uses('HttpSocket', 'Network/Http');

/**
 * Post Model
 *
 */
class Post extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'title' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'body' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public function queryDoc( $id ) {

		$HttpSocket = new HttpSocket();

		try {
			$response = $HttpSocket->get( ES_BASE_URL . '/posts/' . $id . '?pretty' );
		} catch (Exception $e) {
			
		}
		
		if ( isset( $response ) ) {

			$temp = json_decode( $response->body, true );

			$arr['Post'] = $temp['_source'];

			return $arr;
		}
		else {
			return false;
		}
	}

	public function createIndex( $id ) {

		$data = $this->findById($id);

		$HttpSocket = new HttpSocket();

		try {
			$HttpSocket->put( ES_BASE_URL . '/posts/' . $id . '?pretty', json_encode($data['Post']) );			
		} catch (Exception $e) {
			
		}
	}

	public function listAll( $keyword = false, $price_max = false, $price_min = false ) {

		$HttpSocket = new HttpSocket();

        if ( $keyword ) {

        	$str = $this->makeSearchString( $keyword );
            $matchQuery = array(
                'match' => array(
                    'title' => $str
                )
            );
        }
        else {
            $matchQuery = array(
                'match_all' => array()
            );
        }

        $query = array('query' => $matchQuery );

		try {
			$resp = $HttpSocket->post( ES_BASE_URL . '/posts/_search?pretty', json_encode( $query ) );			
		} catch (Exception $e) {
			
		}

		if ( isset( $resp ) ) {
			$temp = json_decode($resp, true);

            if ( $temp['hits']['total'] > 0 ) {
    			$tArr = $temp['hits']['hits'];
    
    			foreach ($tArr as $key => $value) {
    				$fArr[]['Post'] = $value['_source'];
    			}
    			return $fArr;
            }
            else {
                return false;
            }
		}
		else {
			return false;
		}
	}
}
