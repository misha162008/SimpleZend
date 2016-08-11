<?php
namespace Album\Model;
 
use Zend\Db\TableGateway\TableGateway;
 
class AlbumTable
{
    protected $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
 
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
 
    public function getCatalog($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
 
    public function saveCatalog(Catalog $catalog)
    {
        $data = array(
            'artist' => $catalog->artist,
            'title'  => $catalog->title,
        );
 
        $id = (int)$catalog->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAlbum($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
 
    public function deleteCatalog($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}
