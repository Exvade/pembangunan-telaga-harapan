<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','description','target_amount','is_active'];

    public function incomes() { return $this->hasMany(Income::class); }
    public function expenses() { return $this->hasMany(Expense::class); }

    // Helper ringkas
    public function totalIncome(): int  { return (int) $this->incomes()->sum('amount'); }
    public function totalExpense(): int { return (int) $this->expenses()->sum('amount'); }
    public function balance(): int      { return $this->totalIncome() - $this->totalExpense(); }
}
