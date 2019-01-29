<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Repositories\PlanRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class PlanController extends AppBaseController
{
    /** @var  PlanRepository */
    private $planRepository;

    public function __construct(PlanRepository $planRepo)
    {
        $this->planRepository = $planRepo;
    }

    /**
     * Display a listing of the Plan.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->planRepository->pushCriteria(new RequestCriteria($request));
        $plans = $this->planRepository->paginate(20);

        return view('plans.index')
            ->with('plans', $plans);
    }

    /**
     * Show the form for creating a new Plan.
     *
     * @return Response
     */
    public function create()
    {
        return view('plans.create');
    }

    /**
     * Store a newly created Plan in storage.
     *
     * @param CreatePlanRequest $request
     *
     * @return Response
     */
    public function store(CreatePlanRequest $request)
    {
        $input = $request->all();

        $plan = $this->planRepository->create($input);

        Flash::success('Plan saved successfully.');

        return redirect(route('plans.index'));
    }

    /**
     * Display the specified Plan.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $plan = $this->planRepository->findWithoutFail($id);

        if (empty($plan)) {
            Flash::error('Plan not found');

            return redirect(route('plans.index'));
        }

        return view('plans.show')->with('plan', $plan);
    }

    /**
     * Show the form for editing the specified Plan.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $plan = $this->planRepository->findWithoutFail($id);

        if (empty($plan)) {
            Flash::error('Plan not found');

            return redirect(route('plans.index'));
        }

        return view('plans.edit')->with('plan', $plan);
    }

    /**
     * Update the specified Plan in storage.
     *
     * @param  int              $id
     * @param UpdatePlanRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePlanRequest $request)
    {
        $plan = $this->planRepository->findWithoutFail($id);

        if (empty($plan)) {
            Flash::error('Plan not found');

            return redirect(route('plans.index'));
        }

        $plan = $this->planRepository->update($request->all(), $id);

        Flash::success('Plan updated successfully.');

        return redirect(route('plans.index'));
    }

    /**
     * Remove the specified Plan from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $plan = $this->planRepository->findWithoutFail($id);

        if (empty($plan)) {
            Flash::error('Plan not found');

            return redirect(route('plans.index'));
        }

        $this->planRepository->delete($id);

        Flash::success('Plan deleted successfully.');

        return redirect(route('plans.index'));
    }
}
