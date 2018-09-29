<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\equipment\Equipment;
use DB;

class HomeController extends Controller
{
    private $url = "http://192.168.0.100/";
    private $equipment;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Equipment $equipment) {
        $this->middleware('auth');
        $this->equipment = $equipment;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dispositivos = $this->dispositivo();
        return view('home', compact('dispositivos'));
    }

    public function ligar(int $idEquip)
    {   $EquipArdu = $idEquip - 1;
        $on = "OL{$EquipArdu}_ON";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url . $on);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output    = curl_exec($ch);
        $equipment = $this->equipment->statusLigar($idEquip);
        if($equipment['success']):
            $mens         = 'Dispositivo Ligado!';
            $dispositivos = $this->dispositivo();
            return view('home', compact('mens', 'dispositivos'));
            curl_close($ch);
        endif;
    }

    public function desligar(int $idEquip)
    {   $EquipArdu = $idEquip - 1;
        $off = "OL{$EquipArdu}_OFF";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url . $off);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output    = curl_exec($ch);
        $equipment = $this->equipment->statusDesligar($idEquip);
        if($equipment['success']):
            $mens         = 'Dispositivo Desligado!';
            $dispositivos = $this->dispositivo();
            return view('home', compact('mens', 'dispositivos'));
            curl_close($ch);
        endif;
    }

    public function ligarTodos()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url . "OLALL_ON");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);
        $equipment = $this->equipment->statusLigarTodos();
        if($equipment['success']):
            $mens         = 'Todos os dispositivo foram Ligados!';
            $dispositivos = $this->dispositivo();
            return view('home', compact('mens', 'dispositivos'));
            curl_close($ch);
        endif;
    }

    public function deslTodos()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url . "OLALL_OFF");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);
        $equipment = $this->equipment->statusDesligarTodos();
        if($equipment['success']):
            $mens         = 'Todos os dispositivos foram desligados!';
            $dispositivos = $this->dispositivo();
            return view('home', compact('mens', 'dispositivos'));
            curl_close($ch);
        endif;
    }

    public function dispositivo()
    {
        $dispositivos = DB::table('equipment')->select('id', 'nome', 'descricao', 'status', 'ativo')->paginate(5);

        for ($i = 0; $i < count($dispositivos); $i++) {
            $dispositivos[$i]->status = ($dispositivos[$i]->status == 1) ? 'Ligado' : 'Desligado';
            $dispositivos[$i]->ativo  = ($dispositivos[$i]->ativo  == 1) ? 'Ativo'  : 'Desativado';
        }
        return $dispositivos;
    }
}
