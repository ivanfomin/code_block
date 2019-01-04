<?php

namespace App;


use Aura\SqlQuery\QueryFactory;

class QueryBuilder
{
    protected $queryFactory;
    protected $pdo;
    
    public function __construct(\PDO $pdo)
    {
        $this->queryFactory = new QueryFactory('mysql');
        $this->pdo = $pdo;
    }
    
    public function selectAll($table)
    {
        $select = $this->queryFactory->newSelect();
        
        $select->cols(['*'])->from($table);
        
        $sth = $this->pdo->prepare($select->getStatement());
        
        $sth->execute($select->getBindValues());
        
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        
        return $result;
        
    }
    
    public function selectOne($id, $table)
    {
        $select = $this->queryFactory->newSelect();
        
        $select->cols(['*'])->from($table)->where('id = :id');
        
        $sth = $this->pdo->prepare($select->getStatement());
        
        $select->bindValues([':id' => $id]);
        
        $sth->execute($select->getBindValues());
        
        $result = $sth->fetch(\PDO::FETCH_ASSOC);
        
        return $result;
        
    }
    
    public function insert($table, $title, $content, $create_id)
    {
        $insert = $this->queryFactory->newInsert();
        
        $insert
            ->into($table)
            ->cols([
                'title',
                'content',
                'create_id'
            ])
            ->set('datecr', 'NOW()')
            ->bindValues([
                'title'   => $title,
                'content' => $content,
                'create_id' => $create_id
            ]);
        
        $sth = $this->pdo->prepare($insert->getStatement());
        
        $sth->execute($insert->getBindValues());
        
    }
    
    
    public function update($id, $table, $title, $content)
    {
        $update = $this->queryFactory->newUpdate();
        
        $update
            ->table($table)
            ->cols(
                [
                    'title', 'content',
                ]
            )
            ->set('datecr', 'NOW()')
            ->where('id = :id')
            ->bindValues([
                'id'      => $id,
                'title'   => $title,
                'content' => $content,
            ]);
        
        $sth = $this->pdo->prepare($update->getStatement());
        
        $sth->execute($update->getBindValues());
    }
    
    public function delete($id, $table)
    {
        $delete = $this->queryFactory->newDelete();
        
        $delete
            ->from($table)
            ->where('id = :id')
            ->bindValue('id', $id);
        
        $sth = $this->pdo->prepare($delete->getStatement());

        $sth->execute($delete->getBindValues());
    }
}