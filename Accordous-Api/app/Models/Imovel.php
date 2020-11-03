<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Imovel extends Model
{

    use SoftDeletes;
    
    public $table = 'imovel';

    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    // protected $dates = ['deleted_at'];



    public $fillable = [
        'email',
        'rua',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
       
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'email' => 'string',
        'rua' => 'string',
        'numero' => 'integer',
        'complemento' => 'string',
        'bairro' => 'string',
        'cidade' => 'string',
        'estado' => 'string',
        
    ];

    protected $appends = ['EnderecoCompleto'];
    
    public function getEnderecoCompletoAttribute(){
        $Imovel = Imovel::select('rua', 'numero', 'cidade', 'estado')
        ->get();
        
        $enderecoCompleto = '';
        
        foreach ($Imovel as $key => $value) {
            $enderecoCompleto = $value['rua'].', '.$value['numero'].', '.$value['cidade'].' - '.$value['estado'];
        }
        return $enderecoCompleto;
    }
}
