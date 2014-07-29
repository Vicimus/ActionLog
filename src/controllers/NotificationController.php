<?php

namespace Vicimus\ActionLog\Controllers;

class NotificationController extends \BaseController
{

	public function index()
	{
		$subs = \Vicimus\ActionLog\Models\Subscription::all();
		return \View::make('actionlog::notify.config', compact('subs'));
	}

	public function config()
	{
		$sub = new \Vicimus\ActionLog\Models\Subscription();
		$sub->route = \Input::get('route');
		$sub->keywords = \Input::get('keywords');
		$sub->email = \Input::get('email');
		$sub->save();

		return \Redirect::route('actionlog.notify');
	}

	public function edit($id)
	{
		$subs = \Vicimus\ActionLog\Models\Subscription::all();
		$edit = \Vicimus\ActionLog\Models\Subscription::find($id);
		$data['subs'] = $subs;
		$data['edit'] = $edit;

		return \View::make('actionlog::notify.config', compact('data'));
	}

	public function update($id)
	{
		$sub = \Vicimus\ActionLog\Models\Subscription::find($id);
		$sub->route = \Input::get('route');
		$sub->keywords = \Input::get('keywords');
		$sub->email = \Input::get('email');
		$sub->save();

		return \Redirect::route('actionlog.notify')->with('success','Subscription saved successfully');
	}

	public function delete($id)
	{
		$sub = \Vicimus\ActionLog\Models\Subscription::find($id);
		$sub->delete();

		return \Redirect::route('actionlog.notify')->with('success', 'Subscription deleted successfuly');
	}
}