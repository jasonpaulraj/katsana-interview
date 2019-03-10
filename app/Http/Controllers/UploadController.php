<?php
namespaceAppHttpControllers;
useIlluminateHttpRequest;
useIlluminateSupportFacadesValidator;
useResponse;
useIlluminateHttpUploadedFile;
useIlluminateSupportFacadesStorage;
class UploadController extends Controller

	{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public

	function index()
		{

		//

		}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public

	function create()
		{

		//

		}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public

	function store(Request $request)
		{
		$path = public_path();
		if (!empty($request->filename))
			{

			// save file in storage

			$file = $request->filename;
			$filename = $request->filename->getClientOriginalName();
			Storage::disk('local')->put('/public/files/json/' . $filename, file_get_contents($file));

			// retrieve file and its contents from storage

			$_retrieve_file = Storage::disk('local')->get('/public/files/json/' . $filename, file_get_contents($file));
			$_data = json_decode($_retrieve_file, true);

			// generate csv
			// dd(count($_data["trips"]));

			$_filename = explode(".", $filename) [0] . '.csv';
			$download_path = '/assets/files/csv/' . $_filename;
			$f = fopen($path . '/assets/files/csv/' . $_filename, 'w');

			// dd($_totalTrips);
			// $_totaldataTypes = count($_data);

			$_sub_count = 0;
			$header = false;
			$columns = array(
				'id',
				'start_id',
				'start_latitude',
				'start_longitude',
				'start_tracked_at',
				'end_id',
				'end_latitude',
				'end_longitude',
				'end_tracked_at',
				'distance',
				'duration',
				'max_speed',
				'idle_duration',
				'score',
				'idles_id',
				'idles_latitude',
				'idles_longitude',
				'idles_tracked_at',
				'idles_voltage',
				'idles_distance',
				'histories_id',
				'histories_latitude',
				'histories_longitude',
				'histories_tracked_at',
				'histories_speed',
				'histories_voltage',
				'histories_distance',
				'violations'
			);
			fputcsv($f, $columns);

			// trips

			foreach($_data["trips"] as $_line)
				{
				$_csv = array(
					$_line['id']
				);
				foreach($_line['start'] as $v)
					{
					array_push($_csv, $v);
					}

				foreach($_line['end'] as $v)
					{
					array_push($_csv, $v);
					}

				array_push($_csv, $_line['distance']);
				array_push($_csv, $_line['duration']);
				array_push($_csv, $_line['max_speed']);
				array_push($_csv, $_line['average_speed']);
				array_push($_csv, $_line['idle_duration']);
				array_push($_csv, $_line['score']);
				if (is_null($_line['idles']))
					{
					array_push($_csv, $_line['idles']);
					}
				  else
					{
					foreach($_line['idles'] as $v)
						{
						foreach($v as $_v)
							{
							array_push($_csv, $_v);
							}
						}
					}

				foreach($_line['histories'] as $v)
					{
					foreach($v as $_v)
						{
						array_push($_csv, $_v);
						}
					}

				if (is_null($_line['violations']))
					{
					array_push($_csv, $_line['violations']);
					}
				  else
					{
					foreach($_line['violations'] as $v)
						{
						array_push($_csv, $v);
						}
					}

				fputcsv($f, $_csv);
				}

			// summary

			$empty = array();
			$columns2 = array(
				'max_speed',
				'distance',
				'violation'
			);
			fputcsv($f, $empty);
			fputcsv($f, $columns2);
			$_csv_summary = array(
				$_data["summary"]['max_speed']
			);
			array_push($_csv_summary, $_data["summary"]['distance']);
			array_push($_csv_summary, $_data["summary"]['violation']);
			fputcsv($f, $_csv_summary);

			// duration

			$columns3 = array(
				'from',
				'to'
			);
			fputcsv($f, $empty);
			fputcsv($f, $columns3);
			$_csv_duration = array(
				$_data["duration"]['from']
			);
			array_push($_csv_duration, $_data["duration"]['to']);
			fputcsv($f, $_csv_duration);

			// $_csv = array($_summary);
			//     fputcsv($f, $_csv);
			// }
			// foreach ($_data as $_line)
			// {
			//     if (empty($header))
			//     {
			//         foreach($_line as $_sub){
			//             $header = array_keys($_sub);
			//             foreach(array($_sub['start']) as $start){
			//                 array_merge($header, array_keys($start));
			//             }
			//             foreach(array($_sub['end']) as $end){
			//                 array_merge($header, array_keys($end));
			//             }
			//             foreach(array($_sub['idles']) as $idles){
			//                 array_merge($header, array_keys($idles));
			//             }
			//         }
			//         $header = array_flip($header);
			//         foreach($_line as $_sub){
			//             $id = $_sub["id"];
			//             $distance = $_sub["distance"];
			//             $duration = $_sub["duration"];
			//             $max_speed = $_sub["max_speed"];
			//             $average_speed = $_sub["average_speed"];
			//             $score = $_sub["score"];
			//             $_csv = array($_sub['start']);
			//         //    //clear variables list
			//         //  $start_id=$start_latitude=$start_longitude=$start_tracked_at="";
			//         //  $end_id=$end_latitude=$end_longitude=$end_tracked_at="";
			//         //  $idles_id=$idles_latitude=$idles_longitude=$idles_tracked_at=$idles_voltage=$idles_distance="";
			//             if(!empty($_sub['start'])){
			//                 foreach ($_sub['start'] as $v)
			//                 {
			//                     var_dump($v);
			//                     array_push($_csv, $v);
			//                     // if($key === 'id'){
			//                     //     $start_id="";
			//                     //     $start_id = $start[$key];
			//                     // }
			//                     // if($key === 'latitude'){
			//                     //     $start_latitude="";
			//                     //     $start_latitude = $start[$key];
			//                     // }
			//                     // if($key === 'longitude'){
			//                     //     $start_longitude="";
			//                     //     $start_longitude = $start[$key];
			//                     // }
			//                     // if($key === 'tracked_at'){
			//                     //     $start_tracked_at="";
			//                     //     $start_tracked_at = $start[$key];
			//                     // }
			//                 }
			//             }
			//             fputcsv($f, $_csv);
			//             // if(!empty($_sub['end'])){
			//             //     foreach ($_sub['end'] as $key1 => $v1)
			//             //     {
			//             //         if($key1 === 'id'){
			//             //             $end_id = $end[$key1];
			//             //         }
			//             //         if($key1 === 'latitude'){
			//             //             $end_latitude = $end[$key1];
			//             //         }
			//             //         if($key1 === 'longitude'){
			//             //             $end_longitude = $end[$key1];
			//             //         }
			//             //         if($key1 === 'tracked_at'){
			//             //             $end_tracked_at = $end[$key1];
			//             //         }
			//             //     }
			//             // }
			//             // if(!empty($_sub['idles'])){
			//             //     foreach ($_sub['idles'] as $key => $v)
			//             //     {
			//             //         if($key === 'id'){
			//             //             $idles_id = $idles[$key];
			//             //         }
			//             //         if($key === 'latitude'){
			//             //             $idles_latitude = $idles[$key];
			//             //         }
			//             //         if($key === 'longitude'){
			//             //             $idles_longitude = $idles[$key];
			//             //         }
			//             //         if($key === 'tracked_at'){
			//             //             $idles_tracked_at = $idles[$key];
			//             //         }
			//             //         if($key === 'voltage'){
			//             //             $idles_voltage = $idles[$key];
			//             //         }
			//             //         if($key === 'distance'){
			//             //             $idles_distance = $idles[$key];
			//             //         }
			//             //     }
			//             // } else {
			//             //     $idles_id = "";
			//             //     $idles_latitude = "";
			//             //     $idles_longitude = "";
			//             //     $idles_tracked_at = "";
			//             //     $idles_voltage = "";
			//             //     $idles_distance = "";
			//             // }
			//             // if(!empty($_sub['idles'])){
			//             //     foreach ($_sub['idles'] as $key => $v)
			//             //     {
			//             //         if($key === 'id'){
			//             //             $idles_id = $idles[$key];
			//             //         }
			//             //         if($key === 'latitude'){
			//             //             $idles_latitude = $idles[$key];
			//             //         }
			//             //         if($key === 'longitude'){
			//             //             $idles_longitude = $idles[$key];
			//             //         }
			//             //         if($key === 'tracked_at'){
			//             //             $idles_tracked_at = $idles[$key];
			//             //         }
			//             //         if($key === 'voltage'){
			//             //             $idles_voltage = $idles[$key];
			//             //         }
			//             //         if($key === 'distance'){
			//             //             $idles_distance = $idles[$key];
			//             //         }
			//             //     }
			//             // } else {
			//             //     $idles_id = "";
			//             //     $idles_latitude = "";
			//             //     $idles_longitude = "";
			//             //     $idles_tracked_at = "";
			//             //     $idles_voltage = "";
			//             //     $idles_distance = "";
			//             // }
			//             // $trips =
			//             // $id.",".
			//             // $start_id.",".$start_latitude.",".$start_longitude.",".$start_tracked_at.",".
			//             // $end_id.",".$end_latitude.",".$end_longitude.",".$end_tracked_at.",".
			//             // $idles_id.",".$idles_latitude.",".$idles_longitude.",".$idles_tracked_at.",".$idles_voltage.",".$idles_distance.",".
			//             // $distance.",".$duration.",".$max_speed.",".$average_speed.",".$score;
			//             // var_dump($trips);
			//             // $exploded_row=explode(',',$trips);
			//             // fputcsv($f,$exploded_row);
			//         }
			//     } else {
			//         foreach($_line as $_sub){
			//             $_csv = array($_sub);
			//             // var_dump($_csv);
			//             fputcsv($f, $_csv);
			//         }
			//     }
			// }

			}

		// return redirect()->back();
		// return redirect()->route( 'landing' )->with( [ 'filename' => $filename, 'download_path' => $download_path ] );

		}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public

	function show($id)
		{

		//

		}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public

	function edit($id)
		{

		//

		}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public

	function update(Request $request, $id)
		{

		//

		}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public

	function destroy($id)
		{

		//

		}
	}
