<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class CollaboratorContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'collaborator_id',
        'position_id',
        'salary',
        'contract_type_id',
        'contract_start_date',
        'contract_end_date',
        'test_period_end_date',
        'contract_file_public_id',
        'contract_file_url',
        'observations',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'contract_start_date' => 'date:Y-m-d',
        'contract_end_date'   => 'date:Y-m-d',
        'test_period_end_date'=> 'date:Y-m-d',
    ];

    public function collaborator(): BelongsTo
    {
        return $this->belongsTo(Collaborator::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function contract_type(): BelongsTo
    {
        return $this->belongsTo(ContractType::class, 'contract_type_id');
    }

    /**
     * Scope: contratos vigentes para una fecha ($on o hoy).
     * Vigente = start <= $on AND (end IS NULL OR $on <= end)
     */
    public function scopeActive(Builder $q, ?Carbon $on = null): Builder
    {
        $on = $on ?: Carbon::today();
        return $q->whereDate('contract_start_date', '<=', $on)
                 ->where(function ($qq) use ($on) {
                     $qq->whereNull('contract_end_date')
                        ->orWhereDate('contract_end_date', '>=', $on);
                 });
    }

    /**
     * Scope: detectar solapamiento con un rango dado [$start, $end].
     * $allowTouching = true permite que un contrato termine el mismo día que el otro inicia
     * sin contarse como solape (exclusivo en un extremo).
     */
    public function scopeOverlaps(Builder $q, Carbon $start, ?Carbon $end, bool $allowTouching = false): Builder
    {
        // Representa infinito para fin abierto:
        $newEnd = $end ?: Carbon::create(9999, 12, 31);

        if ($allowTouching) {
            // NO solapan <=> newEnd < existing.start  OR  existing.end < start
            // => Solapan <=> NOT( ... )
            return $q->whereRaw('NOT ( ? < contract_start_date OR (contract_end_date IS NOT NULL AND contract_end_date < ?) )',
                [$newEnd->toDateString(), $start->toDateString()]
            );
        }

        // Inclusivo (no permite compartir día)
        return $q
            ->whereDate('contract_start_date', '<=', $newEnd)
            ->where(function ($qq) use ($start) {
                $qq->whereNull('contract_end_date')
                ->orWhereDate('contract_end_date', '>=', $start);
            });
    }

    public static function overlapsFor(
        int $collaboratorId,
        Carbon $start,
        ?Carbon $end = null,
        ?int $exceptId = null,
        bool $allowTouching = false
    ): bool {
        return static::query()
            ->where('collaborator_id', $collaboratorId)
            ->when($exceptId, fn ($q) => $q->where('id', '!=', $exceptId))
            ->overlaps($start, $end, $allowTouching)
            ->exists();
    }


    public function isActive(?Carbon $on = null): bool
    {
        $on = $on ?: Carbon::today();
        $start = $this->contract_start_date
            ? Carbon::parse($this->contract_start_date) : null;

        $end   = $this->contract_end_date
            ? Carbon::parse($this->contract_end_date) : null;

        return $start && $start->lte($on) && (is_null($end) || $end->gte($on));
    }

    public function contractType() { return $this->belongsTo(ContractType::class, 'contract_type_id'); }
    public function bank()        { return $this->belongsTo(BankType::class, 'bank_id'); }
    public function eps()         { return $this->belongsTo(EpsType::class, 'eps_id'); }
    public function afpPension()  { return $this->belongsTo(AfpType::class, 'afp_pension_id'); }
    public function afpSaving()   { return $this->belongsTo(AfpType::class, 'afp_saving_id'); }
    public function arl()         { return $this->belongsTo(ArlType::class, 'arl_id'); }
    public function ccf()         { return $this->belongsTo(CcfType::class, 'ccf_id'); }

}
