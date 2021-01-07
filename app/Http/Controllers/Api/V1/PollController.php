<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\CreatePoll;
use App\Http\Requests\Api\PollVoting;
use App\Models\PollAnswer;
use App\Models\PollDetail;
use App\Models\PollOption;
use Illuminate\Support\Facades\DB;

class PollController extends ApiController {

    public function createPoll(CreatePoll $request) {
        $input = request()->all();
        $input['status'] = PollDetail::StatusOngoing;
        $createPollDetail = PollDetail::create($input);
        if (!$createPollDetail) {
            return $this->jsonResponse(false, 500, 'Something went wrong, Please try again.');
        }
        $optionError = false;
        foreach ($input['pollOptions'] as $option) {
            $optionFields = [
                'pollId' => $createPollDetail->id,
                'pollOption' => $option
            ];
            $createOption = PollOption::create($optionFields);
            if (!$createOption) {
                PollOption::where(['pollId' => $createPollDetail->id])->delete();
                PollDetail::where(['id' => $createPollDetail->id])->delete();
                $optionError = true;
                break;
            }
        }
        if ($optionError) {
            return $this->jsonResponse(false, 500, 'Something went wrong, Please try again.');
        } else {
            return $this->jsonResponse(true, 200, 'Poll Created Successfully.', $this->getPollDetailById($createPollDetail->id));
        }
    }

    public function getPollDetailById($id) {
        $getPollDetail = PollDetail::find($id);
        if (!$getPollDetail) {
            return [];
        }

        /**
         * Update poll status if it's not complete
         */
        if ($getPollDetail->pollTiming <= date('Y-m-d H:i:s')) {
            PollDetail::where(['id' => $id])->update(['status' => PollDetail::StatusCompleted]);
            $getPollDetail = PollDetail::find($id);
        }

        $pollData = [];
        $pollData['id'] = $id;
        $pollData['pollName'] = $getPollDetail->pollName;
        $pollData['status'] = PollDetail::pollStatus()[$getPollDetail->status];
        $pollData['pollDescription'] = $getPollDetail->pollDescription;
        $options = [];
        $totalAnswer = PollAnswer::where(['pollId' => $id])->count();
        foreach ($getPollDetail->getPollOption as $option) {
            $optionItem = [];
            $optionItem['optionId'] = $option->id;
            $optionItem['option'] = $option->pollOption;
            $optionItem['totalVotes'] = '0 %';
            /*Check option Percentage*/
            if ($totalAnswer) {
                $getOptionCount = PollAnswer::where(['pollId' => $id, 'optionId' => $option->id])->count();
                $getPercentage = ($getOptionCount * 100) / $totalAnswer;
                $optionItem['totalVotes'] = number_format($getPercentage, '2', '.', '') . ' %';
            }
            $options[] = $optionItem;
        }
        $pollData['options'] = $options;
        return $pollData;
    }

    public function pollDetail($id) {
        return $this->jsonResponse(true, 200, 'Detail fetch successfully.', $this->getPollDetailById($id));
    }

    public function pollVoting(PollVoting $request) {
        $input = request()->all();
        $checkPoll = $this->getPollDetailById($input['pollId']);
        if($checkPoll['status'] == PollDetail::pollStatus()[PollDetail::StatusCompleted]){
            return $this->jsonResponse(false, 422, 'Not an ongoing poll.');
        }
        $getPollAnswer = PollOption::where(['pollId' => $input['pollId'], 'id' => $input['optionId']])->first();
        if (!$getPollAnswer) {
            return $this->jsonResponse(false, 422, 'Invalid Input data.');
        }
        $createData = [
            'pollId' => $input['pollId'],
            'userId' => auth()->id(),
        ];
        PollAnswer::where($createData)->delete(); // this is so they can change their vode for their poll
        $createData['optionId'] = $input['optionId'];
        PollAnswer::create($createData);
        return $this->jsonResponse(true, 200, 'Vote successfully');
    }

    public function pollResult($id) {
        $getPollDetail = $this->getPollDetailById($id);
        if (!$getPollDetail) {
            return $this->jsonResponse(false, 422, 'No poll exist with given id.');
        }
        if ($getPollDetail['status'] == PollDetail::StatusOngoing) {
            return $this->jsonResponse(false, 200, 'Poll is still ongoing.');
        }
        $getPollDetail = $this->getPollDetailById($id);
        $winnerPercentage = 0;
        foreach ($getPollDetail['options'] as $option) {
            $getOptionPercentage = (float)$option['totalVotes'];
            if ($winnerPercentage <= $getOptionPercentage) {
                $winnerPercentage = $getOptionPercentage;
                $getPollDetail['winnerOption'] = [
                    'optionId' => $option['optionId'],
                    'option' => $option['option'],
                    'totalVotes' => $option['totalVotes'],
                ];
            }
        }
        return $this->jsonResponse(true, 200, 'Poll result fetch successfully.', $getPollDetail);
    }

    public function allPolls() {
        $allPoll = PollDetail::paginate(PollDetail::Pagination);
        return $this->jsonResponse(true, 200, 'Poll fetch successfully.', $allPoll);
    }

}
