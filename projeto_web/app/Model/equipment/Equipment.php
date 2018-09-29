<?php

namespace App\Model\Equipment;

use Illuminate\Database\Eloquent\Model;
use DB;

class Equipment extends Model
{
    
    public function statusLigar(int $idEquip)
    {  DB::beginTransaction();
        $equipment = Equipment::where('id', $idEquip)->update(['status' => 1]);
        if ($equipment) {
            DB::commit();
            return [
                'success' => true
            ];
        } else {
            DB::rollback();
            return [
                'success' => false,
                'message' => 'Erro ao alterar status do equipamento ao ligar!'
            ];
        }
    }

    public function statusDesligar(int $idEquip)
    {  DB::beginTransaction();
        $equipment = Equipment::where('id', $idEquip)->update(['status' => 0]);
        if ($equipment) {
            DB::commit();
            return [
                'success' => true
            ];
        } else {
            DB::rollback();
            return [
                'success' => false,
                'message' => 'Erro ao alterar status do equipamento ao desligar!'
            ];
        }
    }

    public function statusLigarTodos()
    {  DB::beginTransaction();
        $equipment = Equipment::where('ativo', 1)->update(['status' => 1]);
        if ($equipment) {
            DB::commit();
            return [
                'success' => true
            ];
        } else {
            DB::rollback();
            return [
                'success' => false,
                'message' => 'Erro ao alterar status do equipamento ao ligar!'
            ];
        }
    }

    public function statusDesligarTodos()
    {  DB::beginTransaction();
        $equipment = Equipment::where('ativo', 1)->update(['status' => 0]);
        if ($equipment) {
            DB::commit();
            return [
                'success' => true
            ];
        } else {
            DB::rollback();
            return [
                'success' => false,
                'message' => 'Erro ao alterar status do equipamento ao desligar!'
            ];
        }
    }
}
