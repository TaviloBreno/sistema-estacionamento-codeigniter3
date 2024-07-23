<?php
defined('BASEPATH') or exit('Acesso restrito!');

class Mensalidades_model extends CI_Model
{
	public function get_all()
	{
		$this->db->select([
			'mensalidades.*',
			'precificacoes.precificacao_id',
			'precificacoes.precificacao_categoria',
			'precificacoes.precificacao_valor_mensalidade',
			'mensalistas.mensalista_id',
			'mensalistas.mensalista_nome',
			'mensalistas.mensalista_cpf',
			'mensalistas.mensalista_dia_vencimento',
		]);

		$this->db->join('precificacoes', 'precificacoes.precificacao_id = mensalidades.mensalidade_precificacao_id', 'LEFT');
		$this->db->join('mensalistas', 'mensalistas.mensalista_id = mensalidades.mensalidade_mensalista_id', 'LEFT');

		return $this->db->get('mensalidades')->result();
	}

	public function update(string $id, array $data)
	{
		$this->db->update('mensalidades', $data, ['mensalidade_id' => $id]);
		return $this->db->affected_rows();
	}

	public function get_by_id(string $id)
	{
		$this->db->select([
			'mensalidades.*',
			'precificacoes.precificacao_id',
			'precificacoes.precificacao_categoria',
			'precificacoes.precificacao_valor_mensalidade',
			'mensalistas.mensalista_id',
			'mensalistas.mensalista_nome',
			'mensalistas.mensalista_cpf',
			'mensalistas.mensalista_dia_vencimento',
		]);

		$this->db->join('precificacoes', 'precificacoes.precificacao_id = mensalidades.mensalidade_precificacao_id', 'LEFT');
		$this->db->join('mensalistas', 'mensalistas.mensalista_id = mensalidades.mensalidade_mensalista_id', 'LEFT');

		return $this->db->get_where('mensalidades', ['mensalidade_id' => $id])->row();
	}

	public function insert(array $data)
	{
		$this->db->insert('mensalidades', $data);
		return $this->db->insert_id();
	}

	public function delete(string $id)
	{
		$this->db->delete('mensalidades', ['mensalidade_id' => $id]);
		return $this->db->affected_rows();
	}
}
