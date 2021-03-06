/**
 * Copyright (C) 2015 DataTorrent, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *         http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
package com.datatorrent.contrib.couchbase;

import net.spy.memcached.internal.OperationFuture;

/**
 * AbstractCouchBaseSetOperator which extends AbstractCouchBaseOutputOperator and implements set functionality of couchbase.
 *
 * @since 2.0.0
 */
public abstract class AbstractCouchBaseSetOperator<T> extends AbstractCouchBaseOutputOperator<T>
{
  @Override
  public OperationFuture<Boolean> processKeyValue(String key, Object value)
  {
    OperationFuture<Boolean> future = store.getInstance().set(key, value);
    return future;
  }
}
