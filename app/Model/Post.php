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

	public function listAll() {

		$HttpSocket = new HttpSocket();

		try {
			$resp = $HttpSocket->get( ES_BASE_URL . '/posts/_search?pretty' );			
		} catch (Exception $e) {
			
		}

		if ( $resp ) {
			$temp = json_decode($resp, true);

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
}
