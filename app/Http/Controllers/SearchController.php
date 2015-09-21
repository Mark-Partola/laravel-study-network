<?php namespace Chatty\Http\Controllers;

use Illuminate\Http\Request;
use Chatty\Models\User;

class SearchController extends Controller
{

	public function getResults(Request $request) {
		$query = $request->get('query');

		if(!$query) {
			return redirect()->route('home');
		}

		$users = User::where(
			\DB::raw("CONCAT(first_name, ' ', last_name)"),
			'LIKE', "%{$query}%")
			->orWhere('username', 'LIKE', "%{$query}%")
			->get();

		return view('search.results')->with('users', $users);
	}

}