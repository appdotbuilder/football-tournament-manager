<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMatchRequest extends FormRequest
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
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'match_date' => 'required|date',
            'venue' => 'required|string|max:255',
            'referee' => 'nullable|string|max:255',
            'home_score' => 'nullable|integer|min:0',
            'away_score' => 'nullable|integer|min:0',
            'status' => 'required|in:scheduled,in_progress,completed,postponed',
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
            'home_team_id.required' => 'Home team is required.',
            'away_team_id.required' => 'Away team is required.',
            'away_team_id.different' => 'Home team and away team must be different.',
            'match_date.required' => 'Match date is required.',
            'venue.required' => 'Venue is required.',
            'status.required' => 'Match status is required.',
            'home_score.min' => 'Home score cannot be negative.',
            'away_score.min' => 'Away score cannot be negative.',
        ];
    }
}