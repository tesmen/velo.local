<?php

namespace VelovitoBundle\Model\Admin;

use Doctrine\ORM\EntityManager;
use VelovitoBundle\C;
use VelovitoBundle\Entity\AttributeReference;
use VelovitoBundle\Entity\AttributeReferenceItem;
use VelovitoBundle\Entity\Product;
use VelovitoBundle\Entity\ProductAttribute;
use VelovitoBundle\Entity\ProductAttributeMap;
use VelovitoBundle\Entity\ProductCategory;

class AdminModel
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;

        $this->productsRepo = $em->getRepository(C::REPO_PRODUCT);
        $this->productsAttrRepo = $em->getRepository(C::REPO_PRODUCT_ATTR);
        $this->productsAttrMapRepo = $em->getRepository(C::REPO_PRODUCT_ATTR_MAP);
        $this->productsAttrReferenceRepo = $em->getRepository(C::REPO_ATTRIBUTE_REFERENCE);
        $this->productCatRepo = $em->getRepository(C::REPO_CATEGORY);
    }

    /**
     * @return Product[]
     */
    public function getAllProducts()
    {
        return $this->productsRepo->findAll();
    }

    public function getApiTables()
    {
        return [
            $this->productsRepo->getTableName(),
            $this->productCatRepo->getTableName(),
        ];
    }

    /**
     * @return ProductCategory[]
     */
    public function getAllCategories()
    {
        return $this->productCatRepo->findAll();
    }

    /**
     * @return ProductAttribute[]
     */
    public function getAlLProductAttributes()
    {
        return $this->productsAttrRepo->findAll();
    }

    /**
     * @return ProductAttribute[]
     */
    public function getAttributesByProductId($id)
    {
        return $this->productsAttrRepo->findBy([
            '',
        ]);
    }

    /**
     * @return AttributeReference[]
     */
    public function getAllAttributeReferences()
    {
        return $this->em->getRepository(C::REPO_ATTRIBUTE_REFERENCE)->findAll();
    }

    /**
     * @return AttributeReference[]
     */
    public function getEnabledAttrReferences()
    {
        return $this->em->getRepository(C::REPO_ATTRIBUTE_REFERENCE)->findBy([
            'active' => true,
        ]);
    }

    /**
     * @return ProductAttribute[]
     */
    public function getEnabledProductAttributes()
    {
        return $this->em->getRepository(C::REPO_PRODUCT_ATTR)->findBy([
            'active' => true,
        ]);
    }

    /**
     * @return array
     */
    public function getAttrReferencesForForm($appendNotSelected = true)
    {
        $result = [];

        if ($appendNotSelected) {
            $result['-Not selected-'] = 0;
        }

        foreach ($this->getEnabledAttrReferences() as $ref) {
            $name = sprintf('%s - %s', $ref->getName(), $ref->getComment());
            $result[$name] = $ref->getId();
        };

        ksort($result);

        return $result;
    }


    public function getEnabledAttributesForForm($appendNotSelected = true)
    {
        $result = [];

        if ($appendNotSelected) {
            $result['-Not selected-'] = 0;
        }

        foreach ($this->getEnabledProductAttributes() as $ref) {
            $name = sprintf('%s - %s', $ref->getName(), $ref->getComment());
            $result[$name] = $ref->getId();
        };

        ksort($result);

        return $result;
    }

    /**
     * @param $id
     * @return AttributeReference
     * @throws \VelovitoBundle\Exception\NotFoundException
     */
    public function getAttributeReferenceById($id)
    {
        return $this->em->getRepository(C::REPO_ATTRIBUTE_REFERENCE)->findOneOrFail(['id' => $id]);
    }

    /**
     * @param $id
     * @return AttributeReferenceItem
     * @throws \VelovitoBundle\Exception\NotFoundException
     */
    public function getAttributeReferenceItemById($id)
    {
        return $this->em->getRepository(C::REPO_ATTRIBUTE_REFERENCE_ITEM)->findOneOrFail(['id' => $id]);
    }

    /**
     * @param $id
     * @return AttributeReferenceItem[]
     * @deprecated
     */
    public function getAllReferenceItems($id)
    {
        return $this->em->getRepository(C::REPO_ATTRIBUTE_REFERENCE_ITEM)->findBy(
            ['reference' => $id],
            ['isActive' => 'ASC']
        );
    }

    /**
     * @param $id
     * @param $action 1|0
     * @return boolean
     */
    public function toggleReferenceItemStatus($id, $action)
    {
        $ent = $this->getAttributeReferenceItemById($id);

        if ($action) {
            $ent->setIsActive(true);
        } else {
            $ent->setIsActive(false);
        }

        $this->em->flush($ent);

        return true;
    }

    public function getReferenceIdByItemId($id)
    {
        $ent = $this->getAttributeReferenceItemById($id);

        return $ent->getReference();

    }

    /**
     * @param $id
     * @return ProductAttribute
     */
    public function getProductAttributeById($id)
    {
        return $this->productsAttrRepo->findOneOrFail(
            ['id' => $id]
        );
    }

    /**
     * @param $id
     * @return Product
     * @throws \VelovitoBundle\Exception\NotFoundException
     */
    public function getProductById($id)
    {
        return $this->productsRepo->findOneOrFail(['id' => $id]);
    }

    /**
     * @param $id
     * @return Product
     * @throws \VelovitoBundle\Exception\NotFoundException
     */
    public function getAttributesMapByProductId($id)
    {
        return $this->productsAttrMapRepo->findby([
            'product' => $id,
        ]);
    }

    /**
     *
     * @param $id
     * @return ProductCategory
     * @throws \VelovitoBundle\Exception\NotFoundException
     */
    public function getCategoryById($id)
    {
        return $this->productCatRepo->findOneOrFail(['id' => $id]);
    }

    public function createProduct($name)
    {
        if (empty($name)) {
            throw new \Exception('empty name');
        }

        $this->productsRepo->create($name);
    }

    public function createCategory($name)
    {
        if (empty($name)) {
            throw new \Exception('empty name');
        }

        $this->productCatRepo->create($name);
    }

    public function createOrUpdateProductAttribute($formData, ProductAttribute $productAttribute = null)
    {
        $ent = is_null($productAttribute)
            ? new ProductAttribute()
            : $productAttribute;
        $reference = $this->em->getReference(C::REPO_ATTRIBUTE_REFERENCE, $formData[C::FORM_REFERENCE]);

        $ent
            ->setName($formData[C::FORM_TITLE])
            ->setComment($formData[C::FORM_COMMENT])
            ->setActive(true)
            ->setType($formData[C::FORM_ATTRIBUTE_TYPE]);

        if (ProductAttribute::ATTRIBUTE_TYPE_REFERENCE === $formData[C::FORM_ATTRIBUTE_TYPE]) {
            $ent->setReference($reference);
        }

        $this->em->persist($ent);
        $this->em->flush($ent);
    }

    public function createOrUpdateReference($formData, AttributeReference $attributeReference = null)
    {
        $ent = is_null($attributeReference)
            ? new AttributeReference()
            : $attributeReference;

        $ent
            ->setName($formData[C::FORM_TITLE])
            ->setComment($formData[C::FORM_COMMENT])
            ->setActive(true);

        if (is_null($attributeReference)) {
            $this->em->persist($ent);
        }

        $this->em->flush($ent);
    }

    public function createOrUpdateReferenceItem($formData, $id = null)
    {
        $ent = is_null($id)
            ? new AttributeReferenceItem()
            : $this->getAttributeReferenceItemById($id);


        $isActive = isset($formData[C::FORM_IS_ACTIVE])
            ? $formData[C::FORM_IS_ACTIVE]
            : true;

        $reference = $this->em->getReference(AttributeReference::class, $formData[C::FORM_REFERENCE]);

        $ent
            ->setName($formData['item_name'])
            ->setReference($reference)
            ->setIsActive($isActive);

        $this->em->persist($ent);
        $this->em->flush($ent);
    }

    public function updateCategory($id, $formData)
    {
        $ent = $this->getCategoryById($id);

        $ent
            ->setName($formData[C::FORM_TITLE])
            ->setActive($formData[C::FORM_IS_ACTIVE]);

        $this->em->flush($ent);

        return $ent;
    }

    public function updateProduct($id, $formData)
    {
        $ent = $this->getProductById($id);
        $cat = $this->em->getReference(C::REPO_CATEGORY, $formData[C::FORM_CATEGORY]);

        $ent
            ->setName($formData[C::FORM_TITLE])
            ->setCategory($cat)
            ->setActive($formData[C::FORM_IS_ACTIVE]);

        $this->em->flush($ent);

        return $ent;
    }

    public function createAttributeMap(Product $product, $attributeId)
    {
        $this->productsAttrMapRepo->failOnExists([
            'product'   => $product->getId(),
            'attribute' => $attributeId,
        ]);

        $ent = new ProductAttributeMap();
        $attribute = $this->em->getReference(C::REPO_PRODUCT_ATTR, $attributeId);

        $ent
            ->setProduct($product)
            ->setAttribute($attribute);

        $this->em->persist($ent);
        $this->em->flush($ent);

        return $ent;
    }

    public function deleteAttributeMap($id)
    {
        $this->productsAttrMapRepo->findOneOrFail(['id' => $id])->remove();
        $this->em->flush();

        return true;
    }

    public function getCategoriesWithProductsForForm()
    {
        return $this->productCatRepo->getProductsWithCategories();
    }

    public function getCategoriesForForm()
    {
        return $this->productCatRepo->getActiveCategoriesList();
    }

    public function insert($tableName, $data)
    {
        if (!in_array($tableName, $this->getApiTables())) {
            return false;
        }

        foreach ($data as $key => &$datum) {
            if (is_scalar($datum)) {
                continue;
            }

            if (is_array($datum) && isset($datum['id'])) {
                $datum = $datum['id'];
                continue;
            }

            unset($data[$key]);
        }

        $qb = $this->em->getConnection()->createQueryBuilder()->insert($tableName);

        foreach ($data as $key => $val) {
            $qb->setValue($key, ':' . $key);
        }

        return $qb->setParameters($data)->execute();
    }
}
