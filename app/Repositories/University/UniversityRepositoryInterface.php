<?php

namespace App\Repositories\University;

interface UniversityRepositoryInterface
{
    /**
     * Find a University by its ID.
     *
     * @param mixed $id
     *
     * @return [type]
     */
    public function findById($id);

    /**
     * Create a new University with the provided data.
     *
     * @param array $data
     *
     * @return [type]
     */
    public function create(array $data);

    /**
     * Update the data of an existing University.
     *
     * @param mixed $id
     * @param array $data
     *
     * @return [type]
     */
    public function update($id, array $data);

    /**
     * Get a list of Universities with optional filters and pagination.
     *
     * @param mixed $filters
     * @param mixed $perPage
     *
     * @return [type]
     */
    public function getUniversities($filters, $perPage);

    /**
     * Get the number of collaborations for a specific University.
     *
     * @param mixed $universityId
     *
     * @return [type]
     */
    public function getNumberCooperate($universityId);

    /**
     * Find a University by its slug.
     *
     * @param mixed $slug
     *
     * @return [type]
     */
    public function findBySlug($slug);

    /**
     * Get all enterprises associated with a University, filtered by status.
     *
     * @param mixed $universityId
     * @param mixed $status
     *
     * @return [type]
     */
    public function getAllEnterpriseToUniversity($universityId, $status);

    /**
     * Count the number of majors associated with a University.
     *
     * @param mixed $universityId
     *
     * @return [type]
     */
    public function countMajorToUniversity($universityId);

    /**
     * get school account with role_id = admin
     * @param mixed $university
     *
     * @return [type]
     */
    public function getAdminUser($university);

    /**
     * Check if the business and the case have cooperated
     * @param mixed $enterprise
     * @param mixed $universityId
     *
     * @return [type]
     */
    public function checkCooperateExists($enterprise, $universityId);

    
    public function getCollaborationByUniversity(int $university_id, int $perPage, string $search);
}
