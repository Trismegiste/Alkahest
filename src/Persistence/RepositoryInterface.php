<?php

/*
 * Alkahest
 */

namespace Trismegiste\Alkahest\Persistence;

/**
 * A contract for a repository
 */
interface RepositoryInterface
{

    /**
     * Transforms an object tree into a tree/array and persists it
     * into a database layer
     *
     * @param Persistable $doc
     */
    function persist(Persistable $doc);

    /**
     * Finds an object from the database for a given primary key and
     * maps it with a transformer into a real object.
     *
     * @param string $id the primary key
     *
     * @return Persistable
     *
     * @throws NotFoundException When no object found for this pk
     */
    function findByPk($id);

    /**
     * Creates an instance and maps this object with data retrieved from
     * database. Usefull when using MongoCollection::find
     *
     * @param array $struc a raw structure coming from database
     *
     * @return Persistable
     *
     */
    function createFromDb(array $struc);

    /**
     * Makes a query against current collection
     *
     * @param array $query mongodb query
     * @param array $fields fields to return
     *
     * @return MongoDbCursor internal mongodb cursor
     */
    public function getCursor(array $query = [], array $fields = []);

    /**
     * Makes a query against current repository and returns an iterator on objects
     *
     * @param array $query mongodb query
     *
     * @return CollectionIterator
     */
    public function find(array $query = []);

    /**
     * Makes a query against current repository and returns the first object
     *
     * @param array $query mongodb query
     *
     * @return object|null
     */
    public function findOne(array $query = []);

    /**
     * Like persist() but with a batch of document
     *
     * @param array $batch
     */
    public function batchPersist(array $batch);
}
