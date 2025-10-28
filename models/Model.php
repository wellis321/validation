<?php
abstract class Model {
    protected $db;
    protected $table;
    protected $fillable = [];
    protected $hidden = ['password'];
    public $id = null;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function find($id) {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
        $result = $stmt->fetch();
        return $this->hideProtectedFields($result);
    }

    public function findBy($field, $value) {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE {$field} = ?", [$value]);
        $result = $stmt->fetch();
        return $this->hideProtectedFields($result);
    }

    public function create($data) {
        $filteredData = $this->filterFillableFields($data);
        return $this->db->insert($this->table, $filteredData);
    }

    public function update($id, $data) {
        $filteredData = $this->filterFillableFields($data);
        return $this->db->update($this->table, $filteredData, 'id = ?', [$id]);
    }

    public function delete($id) {
        return $this->db->delete($this->table, 'id = ?', [$id]);
    }

    protected function filterFillableFields($data) {
        return array_intersect_key($data, array_flip($this->fillable));
    }

    protected function hideProtectedFields($data) {
        if (!$data) return $data;
        return array_diff_key($data, array_flip($this->hidden));
    }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        $results = $stmt->fetchAll();
        return array_map([$this, 'hideProtectedFields'], $results);
    }

    public function where($conditions, $params = []) {
        $where = implode(' AND ', array_map(function($field) {
            return "{$field} = ?";
        }, array_keys($conditions)));

        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE {$where}", array_values($conditions));
        $results = $stmt->fetchAll();
        return array_map([$this, 'hideProtectedFields'], $results);
    }

    public function paginate($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->db->query(
            "SELECT * FROM {$this->table} LIMIT ? OFFSET ?",
            [$perPage, $offset]
        );
        $results = $stmt->fetchAll();

        // Get total count for pagination
        $countStmt = $this->db->query("SELECT COUNT(*) as count FROM {$this->table}");
        $totalCount = $countStmt->fetch()['count'];

        return [
            'data' => array_map([$this, 'hideProtectedFields'], $results),
            'total' => $totalCount,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($totalCount / $perPage)
        ];
    }
}
