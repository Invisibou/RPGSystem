<?php 

// Ladino terá pouco dano e uma vida rasoável, mas terá uma habilidade que irá dar 50% de chance de esquivar de um ataque desferido contra ele.
// no combate, todos irão ter pelo menos 2 ações: Se defender ou esquivar (Na defesa ele não terá que fazer nada, somente aguardar que o adversário role o 
// dado e torça para que o adversario tire um dado menor que sua defesa, para que o ataque possa ser completamente anulado. Na esquiva, o jogador irá rolar um 
// dado contra o dado do oponente, caso o dado do oponente seja maior que o dado do jogador, ele irá receber o dano, caso o dado do jogador seja maior, ele conseguirá esquivar.
// Velocidade será um atributo que irá influenciar no acerto dos ataques). Para um personagem normal se defender ou esquivar, ele deverá tirar valor X no dado, 
// para o ladino esquivar, basta o resultado ser par ou ímpar.

// Atributos de personagem:

class CharacterClass
{
    private $ClassName;
    private $BaseLife;
    private $BaseDamage;
    private $BaseDefense;
    private $BaseVelocity;
    private $BonusDamage;
    private $BonusDefense;
    private $BonusVelocity;
    private $BackGround;

    public function __construct(string $ClassName, int $BaseLife, int $BaseDamage, int $BaseDefense, int $BaseVelocity, string $BackGround)
    {
        $this->ClassName = $ClassName;
        $this->BaseLife = $BaseLife;
        $this->BaseDamage = $BaseDamage;
        $this->BaseDefense = $BaseDefense;
        $this->BaseVelocity = $BaseVelocity;
        $this->BackGround = $BackGround;
    }
}
