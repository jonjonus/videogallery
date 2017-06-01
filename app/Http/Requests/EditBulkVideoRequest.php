<?php

    namespace App\Http\Requests;

    use App\Http\Requests\Request;

    class EditBulkVideoRequest extends Request
    {
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public function authorize()
        {
            return true;
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules()
        {
            return [
                'thumbnail'    => 'max:255',
                'thumbnail_sm' => 'max:255',
                'thumbnail_hq' => 'max:255',
                'title'        => 'max:255',
                'name'         => 'max:255',
                'produced_at'  => 'date',
            ];
        }
    }
