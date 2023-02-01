<?php

require_once "./core/connection/Database.php";

class Project
{
    private Database $con;


    public function __construct()
    {
        $this->con = new Database();
    }


    /**
     * insertProject
     *
     * @param  array $data
     * @return bool
     */
    public function insertProject(array $data): bool
    {
        $query = "INSERT INTO projects(name, description, created_at, deadline) 
        VALUES(:name, :description, :created_at, :deadline)";

        return $this->con->write($query, $data);
    }


    /**
     * selectProjectsInProgress
     *
     * @return array
     */
    public function selectProjectsInProgress(): array
    {
        $query = "SELECT *, DATEDIFF(deadline, NOW()) AS remains_days FROM projects
        WHERE is_done=0 ORDER BY remains_days ASC";

        return $this->con->read($query);
    }


    /**
     * selectAllProjects
     *
     * @return array
     */
    public function selectAllProjects(): array
    {
        $query = "SELECT * FROM projects ORDER BY created_at DESC";
        return $this->con->read($query);
    }


    /**
     * selectSingleProject
     *
     * @param  int $id
     * @return array
     */
    public function selectSingleProject(int $id): array
    {
        $query = "SELECT * FROM projects WHERE id_project = :id_project";
        return $this->con->readSingleRow($query, ['id_project' => $id]);
    }

    
    /**
     * updateProject
     *
     * @param array $data
     * @return bool
     */
    public function updateProject(array $data): bool
    {
        $query = "UPDATE projects SET name = :name, description = :description,
        created_at=:created_at, deadline=:deadline, is_done=:is_done
        WHERE id_project=:id_project";

        return $this->con->write($query, $data);
    }


    /**
     * deleteProject
     *
     * @param  int $id
     * @return bool
     */
    public function deleteProject(int $id): bool
    {
        $query = "DELETE FROM projects WHERE id_project = :id_project";
        return $this->con->write($query, ['id_project' => $id]);
    }
}
