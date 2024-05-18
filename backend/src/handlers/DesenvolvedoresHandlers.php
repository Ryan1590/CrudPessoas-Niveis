<?php

namespace src\handlers;

use Exception;

use \src\models\Desenvolvedores;
use \src\models\Nivel;

class DesenvolvedoresHandlers
{

    private static function loadNivel($desenvolvedor)
    {
        foreach ($desenvolvedor as &$dev) {
            $idnivel = $dev['nivel_id'];
            unset($dev['nivel_id']);
            $bucar_niveis = Nivel::select()->where('id', $idnivel)->one();
            $dev['nivel'] = $bucar_niveis;
        }

        return $desenvolvedor;
    }

    public static function getProgramadoresTermo($termo)
    {
        $desenvolvedor = Desenvolvedores::select()->where('nome', 'like', '%' . $termo . '%')->execute();
        if (count($desenvolvedor) == 0) {
            throw new Exception('Nenhum desenvolvedor encontrado!', 404);
        }

        return self::loadNivel($desenvolvedor);
    }

    public static function getProgramadores()
    {
        $desenvolvedor = Desenvolvedores::select()->execute();
        if (count($desenvolvedor) == 0) {
            throw new Exception('Sem Desenvolvedores Cadastrados!', 404);
        }

        return self::loadNivel($desenvolvedor);
    }

    public static function cadastro($desenvolvedor)
    {
        $nivelId = $desenvolvedor['nivel_id'];
        if (!self::nivelExists($nivelId)) {
            throw new Exception('Nível não existe!', 404);
        }

        $existingDev = Desenvolvedores::select()->where('nome', $desenvolvedor['nome'])->first();
        if ($existingDev) {
            throw new Exception('Desenvolvedor com este nome já existe!', 400);
        }

        Desenvolvedores::insert($desenvolvedor)->execute();
        return 'Desenvolvedor cadastrado com sucesso!';
    }

    public static function nivelExists($nivelId)
    {
        $nivel = Nivel::select()->where('id', $nivelId)->execute();
        return count($nivel) > 0;
    }

    public static function editar($id, $dados)
    {
        $desenvolvedor = Desenvolvedores::select()->where('id', $id)->execute();
        if (empty($desenvolvedor)) {
            throw new Exception('Desenvolvedor não encontrado!', 400);
        }

        $existingDev = Desenvolvedores::select()->where('nome', $dados['nome'])->where('id', '!=', $id)->first();
        if ($existingDev) {
            throw new Exception('Desenvolvedor com este nome já existe!', 400);
        }

        Desenvolvedores::update($dados)->where('id', $id)->execute();
        return json_encode(array('message' => 'Desenvolvedor atualizado com sucesso'));
    }

    public static function delete($id)
    {
        Desenvolvedores::delete()->where('id', $id)->execute();
        return 'Desenvolvedor excluído com sucesso!';
    }
}
