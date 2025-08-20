<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMatchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tournament_id' => 'required|exists:tournaments,id',
            'group_id' => 'nullable|exists:groups,id',
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'match_date' => 'required|date',
            'venue' => 'required|string|max:255',
            'referee' => 'nullable|string|max:255',
            'stage' => 'required|in:group_stage_1,group_stage_2,quarterfinals,semifinals,final',
            'notes' => 'nullable|string',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'tournament_id.required' => 'Tournament is required.',
            'home_team_id.required' => 'Home team is required.',
            'away_team_id.required' => 'Away team is required.',
            'away_team_id.different' => 'Home team and away team must be different.',
            'match_date.required' => 'Match date is required.',
            'venue.required' => 'Venue is required.',
            'stage.required' => 'Match stage is required.',
        ];
    }
}